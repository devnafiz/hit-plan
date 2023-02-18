@props(['href' => '#', 'text' => '', 'permission' => false])

<x-utils.link-header :href="$href" class="btn btn-primary btn-sm" icon="fas fa-pencil-alt" :text="$text" permission="{{ $permission }}" />
