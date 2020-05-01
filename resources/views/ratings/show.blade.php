<div class="card">
    <div class="card-header">
        {{__('ratings.latest')}}
        <span class="text-right">
                <form class="form-inline my-2 my-lg-0" action="{{route('sort')}}" method="post">
                    @csrf
                    <select class="form-control mr-sm-2" name="sort" placeholder="{{__('ratings.sort')}}" aria-label="{{__('ratings.sort')}}" required>
                        <option value="0" @if(!Session::get('sort') == "1") selected @endif>{{__('ratings.sortbydate')}}</option>
                        <option value="1" @if(!Session::get('sort') == "0") selected @endif>{{__('ratings.sortbyvote')}}</option>
                    </select>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{__('page.submit')}}</button>
                </form>
            </span>
    </div>
    <div class="card-body">
        @foreach($ratings as $rating)
            <div class="comment">
                <a href="{{route('user', $rating->user)}}">{{\App\User::find($rating->user)->name}}</a>
                <span class="text-right">
                        @if($rating->user == Auth::id())
                        {{__('ratings.title')}}:{{$rating->vote}}
                        <a href="#">{{__('ratings.delete')}}</a>
                        <a href="#">{{__('ratings.edit')}}</a>
                    @endif
                    </span>
                @if($rating->comment != NULL && !empty($rating->comment))
                    <div class="text">{{$rating->comment}}</div>
                @endif
            </div>
        @endforeach
    </div>
</div>
