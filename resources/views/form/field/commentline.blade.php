<p class="commentline_header">
<small>
    {!! $comment->created_user_avatar !!}
    &nbsp;{{ $comment->created_at }}
</small>

&nbsp;

@if($isAbleRemove)
<a href="javascript:void(0);" data-exment-delete="{{$deleteUrl}}">
    <i class="fa fa-trash"></i>
</a>
@endif
</p>

@if(count($mentions) > 0)
<small class="text-muted">Mention To:&nbsp;
    @foreach($mentions as $mention)
    <b>&commat;{!! $mention["user_name"] !!} &nbsp;</b>
    @endforeach
</small>
@endif

<p class="commentline_inner">
{!! replaceBreakEsc($comment->getLabel()) !!}
</p>

<hr />