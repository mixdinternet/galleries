<div class="dropzone" id="mx_dropzone_{{ $name }}" data-url="{{ route('admin.galleries.upload') }}">
    {!! BootForm::hidden('_token', csrf_token()) !!}
    {!! BootForm::hidden('gallery[]', $name)  !!}
</div>

@if($gallery)
    <div class="gallery">
        <ul class="row sortable" data-url="{{ route('admin.galleries.sort') }}"
            data-destroy-url="{{ route('admin.galleries.destroy') }}" id="sortable_{{ $name }}">
            @foreach ($gallery->images()->get() as $k => $v)
                <li class="col-sm-6 col-md-3" id="image_{{ $v->id }}">
                    <div class="box box-solid">
                        <div class="box-header with-border"></div>
                        <div class="box-body">
                            <img src="{{ Image::url($v->name, 640, 480, ['crop']) }}" class="img-responsive"/>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <a href="{{ $v->name }}" title="{{ $v->description }}"
                                   class="btn btn-flat btn-default jq-image-zoom">
                                    <i class="fa fa-search"></i>
                                </a>
                                <a href="#" title="Alterar" class="btn btn-flat btn-primary jq-image-edit"
                                   data-id="{{ $v->id }}" data-description="{{ $v->description }}"
                                   data-image="{{ $v->name }}" data-update-url="{{ route('admin.galleries.update') }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="#" title="Remover" class="btn btn-flat btn-danger jq-image-remove"
                                   data-id="{{ $v->id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif