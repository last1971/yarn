<?php

namespace App\Traits;

trait AuthorizeAdminRequest {
    /**
     * Determine if the user is admin and authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user && $user->hasRole('admin');
    }
}
