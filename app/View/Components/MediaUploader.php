<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;


class MediaUploader extends Component
{
    public $label;
    public $medias;
    public $type;
    public $context;
    public $targetType;
    public $title;
    public $targetId;

    public function __construct($label, $medias = [], $type, $context, $targetType, $title, $targetId)
    {
        $this->label = $label;
        $this->medias = $medias;
        $this->type = $type;
        $this->context = $context;
        $this->targetType = $targetType;
        $this->title = $title;
        $this->targetId = $targetId;
    }

    public function render()
    {
        return view('components.media-uploader');
    }
}
