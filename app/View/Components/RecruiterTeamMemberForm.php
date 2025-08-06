<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class RecruiterTeamMemberForm extends Component
{
    public $recruiter;

    public function __construct($recruiter)
    {
        $this->recruiter = $recruiter;
    }

    public function render(): View|Closure|string
    {
        return view('components.recruiter-team-member-form');
    }
}
