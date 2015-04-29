<?php namespace Incubamas\Repositories;

use Incubamas\Entities\Tag;

class TagRepo extends BaseRepo
{
    public function getModel()
    {
        return new Tag();
    }

    public function newTag()
    {
        return new Tag();
    }

    public function borrarTag($id)
    {
        $tag = Tag::find($id);
        $tag->delete();
    }

    public function tags()
    {
        return Tag::orderBy('tag', 'asc')->get();
    }

    public function tag_tags()
    {
        $tags ='';
        $ts = Tag::orderby('tag')->get();
        foreach($ts as $tag)
            $tags.= '\''.$tag->tag.'\', ';
        return substr($tags, 0, -2);
    }

    public function busca_nombre($tag)
    {
        return Tag::whereRaw("tag LIKE '".$tag."'")->first();
    }
    
}
