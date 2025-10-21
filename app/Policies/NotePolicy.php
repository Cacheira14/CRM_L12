<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Note;

class NotePolicy
{
    /**
     * Determines if the user can view the note.
     */
    public function view(User $user, Note $note): bool
    {
        return $user->isAdmin() || $note->visit->user_id === $user->id;
    }

    /**
     * Determines if the user can create notes.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isCommercial();
    }

    /**
     * Determines if the user can update the note.
     */
    public function update(User $user, Note $note): bool
    {
        return $user->isAdmin() || $note->visit->user_id === $user->id;
    }

    /**
     * Determines if the user can delete the note.
     */
    public function delete(User $user, Note $note): bool
    {
        return $user->isAdmin() || $note->visit->user_id === $user->id;
    }
}
