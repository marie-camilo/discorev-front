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
    public $isMultiple;

    public function __construct($label, $medias = [], $type, $context, $targetType, $title, $targetId, $isMultiple)
    {
        $this->label = $label ?? null;
        $this->medias = $medias;
        $this->type = $type;
        $this->context = $context;
        $this->targetType = $targetType;
        $this->title = $title;
        $this->targetId = $targetId;
        $this->isMultiple = $isMultiple ?? false;
    }

    public function render()
    {
        return view('components.media-uploader');
    }
}
