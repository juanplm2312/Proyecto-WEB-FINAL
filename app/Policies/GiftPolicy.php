<?php

namespace App\Policies;

use App\Models\Gift;
use App\Models\User;

class GiftPolicy
{
    /**
     * Cualquier usuario autenticado puede crear un gift.
     */
    public function create(?User $user)
    {
        return $user !== null;
    }

    /**
     * Solo el creador puede editarlo.
     */
    public function update(User $user, Gift $gift)
    {
        return $user->id === $gift->creator_id;
    }

    /**
     * Solo el creador puede eliminarlo.
     */
    public function delete(User $user, Gift $gift)
    {
        return $user->id === $gift->creator_id;
    }

    /**
     * Cualquier usuario (o invitado, si quieres) puede verlo.
     */
    public function view(?User $user, Gift $gift)
    {
        return true;
    }
}
