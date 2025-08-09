<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryOrder;

class DeliveryOrderPolicy
{

    public function viewAny(User $user)
    {
        // Only allow if user has permission (customize as needed)
        if (!$user->role) return false;
        if (property_exists($user->role, 'can_view_delivery_order')) {
            return $user->role->can_view_delivery_order;
        }
        // fallback: allow super user
        return $user->role->is_super_user ?? false;
    }

    public function view(User $user, DeliveryOrder $order)
    {
        // Super user or creator can view
        return ($user->role && $user->role->is_super_user) || $user->id === $order->creator_id;
    }

    public function create(User $user)
    {
        if (!$user->role) return false;
        if (property_exists($user->role, 'can_create_delivery_order')) {
            return $user->role->can_create_delivery_order;
        }
        return $user->role->is_super_user ?? false;
    }

    public function update(User $user, DeliveryOrder $order)
    {
        // Super user or creator can update
        if ($user->role && ($user->role->is_super_user ?? false)) return true;
        if ($user->role && property_exists($user->role, 'can_edit_delivery_order') && $user->role->can_edit_delivery_order) {
            return $user->id === $order->creator_id;
        }
        return false;
    }

    public function delete(User $user, DeliveryOrder $order)
    {
        // Super user or creator can delete
        if ($user->role && ($user->role->is_super_user ?? false)) return true;
        if ($user->role && property_exists($user->role, 'can_delete_delivery_order') && $user->role->can_delete_delivery_order) {
            return $user->id === $order->creator_id;
        }
        return false;
    }
}
