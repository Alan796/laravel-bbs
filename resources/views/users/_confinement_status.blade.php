@if($user->isConfined())
    <span class="alert-danger center-block text-center">
        @if($user->confinements()->effective()->first()->is_permanent)
            该用户已被永久禁言
        @else
            该用户被禁言至 {{ $user->confinements()->effective()->first()->expired_at->toDateTimeString() }}
        @endif
    </span>
    <hr>
@endif