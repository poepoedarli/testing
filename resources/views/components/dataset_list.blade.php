<div class="block-content block-content-full  pt-2">
    <div class="d-sm-flex">
        <div class="ms-sm-2 me-sm-4 py-2 text-center">
            <a class="item item-rounded bg-body-dark text-dark fs-2 mb-2 mx-auto" href="{{ route('datasets.show', $dataset->id) }}" title="View Dataset">
                <img alt="" src="{{ asset('media/images/datasets/image-dataset.jpg') }}" class="" style="width: 100%" />
            </a>
            <div class="btn-group btn-group-sm">
                @if (Auth::user()->can('dataset-edit'))
                <a class="btn btn-alt-secondary" title="Modify Dataset" href="{{ route('datasets.edit', $dataset->id) }}">
                    <i class="fa fa-edit text-primary"></i>
                </a>
                @endif
                @if (Auth::user()->can('dataset-delete'))
                <a class="btn btn-alt-secondary" title="Delete Dataset" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this Dataset?')) { document.getElementById('delete-form-{{$dataset->id}}').submit(); }">
                    <i class="fa fa-trash text-danger"></i>
                </a>
                @endif 
                <form id="delete-form-{{$dataset->id}}" action="{{ route('datasets.destroy', $dataset->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
        <div class="py-2">
            <a class="link-fx h4 mb-1 d-inline-block text-dark" href="{{ route('datasets.show', $dataset->id) }}" title="View Dataset">
                {{ $dataset->name }}
            </a>
            <div class="fs-sm fw-semibold text-muted mb-2">
                <a href="/users/{{$dataset->creator_id}}" title="Dataset Creator">{{$dataset->creator->name}}</a> - {{ \Carbon\Carbon::parse($dataset->updated_at)->format('d F Y') }}
            </div>
            <p class="mb-2">
                <code class="text-muted ">
                    {{$dataset->data_path}}
                </code>
            </p>
            
            <div>
                @php $tags = explode(',', $dataset->tags) @endphp
                @foreach ($tags as $tag)
                <span class="badge bg-primary">#{{$tag}}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>