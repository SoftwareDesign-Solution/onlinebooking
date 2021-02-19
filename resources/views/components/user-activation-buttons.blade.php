<a href="/cms/users/{{ $userId }}?active=true" class="user-activation-button success" type="submit">
    @svg('assets/icons/check.svg')
</a>

<a href="/cms/users/{{ $userId }}?active=false"  class="user-activation-button error" type="submit">
    @svg('assets/icons/times.svg')
</a>
