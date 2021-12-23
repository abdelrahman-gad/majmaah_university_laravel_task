<div class="row">
    <div class="col-8 offset-1 mb-2">
        @if(session('success'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>