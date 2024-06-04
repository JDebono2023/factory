<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {

        $userAdmin = $user->teams->where('id', '=', '2')->first() || $user->ownedTeams()->count() > 0;

        if (!$userAdmin) {
            return Response::deny('You are not authorized to view this content.');
        } else {
            return Response::allow();
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Team $team): bool
    {
        return $user->belongsToTeam($team);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can add team members.
     */
    public function addTeamMember(User $user, Team $team): bool
    {
        // return $user->ownsTeam($team);

        // Check if the user is the owner of the team
        if ($user->ownsTeam($team)) {
            return true;
        }

        // Check if the user belongs to a team with id == 2
        $teamWithId2 = Team::find(2); // Assuming '2' is the ID of the team
        if ($teamWithId2 && $team->id === $teamWithId2->id && $team->hasUser($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update team member permissions.
     */
    public function updateTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can remove team members.
     */
    public function removeTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Team $team): bool
    {
        return $user->ownsTeam($team);
    }
}
