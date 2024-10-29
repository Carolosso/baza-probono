<div class="{{ $widget['wrapper'] }}"> 
    <div class="card {{ $widget['class'] ?? 'custom_collapse_widget' }}">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-header">
                    {!! $widget['title'] !!}
                </h3>
            </div>
            <div class="mr-2 col-md-5 align-self-center text-end">
                <button class="btn btn-primary" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse-{!! $widget['number'] !!}" 
                        aria-expanded="false" 
                        aria-controls="collapse-{!! $widget['number'] !!}">
                    <i class="las la-chevron-down"></i>&nbsp;Pokaż
                </button>
            </div>              
        </div>
        <div id="collapse-{!! $widget['number'] !!}" 
             class="collapse" 
             aria-labelledby="heading-collapse">
            <div class="card-body">
                {!! $widget['content'] !!}
            </div>
        </div>
    </div>
</div>
