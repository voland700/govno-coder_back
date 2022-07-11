<tr>
    <td class="text-center">{{$childComment->id}}</td>
    <td class="admin-comment-t">{!! $delimiter ?? ""!!} <span class="admin-comment-text">{{$childComment->short}}</span></td>
    <td class="text-center">
        @if ($childComment->active === 0)
            <span class="pale-icon"><i class="far fa-check-circle"></i></span>
        @endif
        @if ($childComment->active === 1)
            <span class="green-icon"><i class="far fa-check-circle"></i></span>
        @endif
    </td>
    <td>{{$childComment->user->name}}</td>
    <td class="text-center">{{$childComment->created_at}}</td>
    <td>
        <a href="{{ route('comment.edit', $childComment->id) }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></a>
        <form method="POST" action="{{ route('comment.destroy',$childComment->id) }}" class="formDelete">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm delete" onclick="return confirm('Подтвердите удаление')"><i class="fas fa-trash-alt"></i></button>
        </form>
    </td>
</tr>
@if(count($childComment->children)>0)
    @foreach ($childComment->children as $childComment)
        @include('admin.comment.child_comments', ['childComment' =>$childComment, 'delimiter' => '<span class="delimiter"></span>' . $delimiter])
    @endforeach
@endif
