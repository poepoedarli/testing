@extends('layouts.backend')
@section('js')
    <script src="{{ asset('js/plugins/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <div class="">
        <div class="block block-rounded mb-2">
            <div class="block-header block-header-default">
                <h3 class="block-title text-secondary">Dataset Template</h3>
            </div>
            <div class="block-content block-content-full">
                @component('components.error')
                    <!-- show error messages  -->
                @endcomponent
                <div class="row align-items-end">
                    <div class="col-10">
                        <div class="form-group">
                            <label class="form-label">Field Type: </label>
                            <select class="form-select" id='field_types'>
                                <option value="textbox" selected>Textbox</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="radiolist">Radio List</option>
                                <option value="select">Select</option>
                                <option value="fileupload">File Upload</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <a class="btn btn-primary d-grid" onclick="addField()">Add Field</a>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::open(['route' => 'dataset_templates.store', 'method' => 'POST']) !!}
        <div id="fields">

        </div>


        <div class="row">
            <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
                <button type="submit" class="btn btn-sm btn-primary me-md-2"><i class="fa fa-save me-1"></i>Submit
                </button>
            </div>
        </div>
        {!! Form::close() !!}
        {{-- Templates --}}
        <div id="templates" class="d-none">
            <div id="textbox_field" class="block block-rounded m-1">
                <div class="block-header block-header-default p-2" role="button" onclick="toggleField(this)">
                    <h3 class="block-title text-secondary">
                        <a class="btn"><i class="fa fa-angle-up collapsible"></i></a>
                        Textbox
                    </h3>
                    <div class="d-flex">
                        <a class="btn btn-outline-danger border-0" onclick="removeField($(this))"><i
                                class="fa fa-trash"></i></a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Textbox Label:</label>
                                <input name="fields[{id}][label]" type="text" class="form-control" placeholder="Label" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Textbox Name: *</label>
                                <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Data Type: </label>
                                <select name="fields[{id}][data_type]" class="form-select">
                                    <option value="string" selected>String</option>
                                    <option value="number">Number</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1 align-self-center">
                            <div class="form-check form-switch">
                                <label class="form-check-label">Multi Line</label>
                                <input class="form-check-input" name="fields[{id}][multiple]" type="checkbox" value="textarea">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 properties">
                        <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                            <h6 class="mb-1">Properties</h6>
                            <span class="btn btn-outline-success border-0 rounded-0" onclick="addAttributeField(this)">
                                <i class="fa fa-plus"></i> Add Attribute
                            </span>
                        </div>

                        <div id="" class="attributes col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Attribute
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeAttributeField($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][properties][attributes][]" class="form-control"
                                        value="id" />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="fields[{id}][properties][values][]" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="checkbox_field" class="block block-rounded m-1">
                <div class="block-header block-header-default p-2" role="button" onclick="toggleField(this)">
                    <h3 class="block-title text-secondary">
                        <a class="btn"><i class="fa fa-angle-up collapsible"></i></a>
                        Checkbox
                    </h3>
                    <div class="d-flex">
                        <a class="btn btn-outline-danger border-0" onclick="removeField($(this))"><i
                                class="fa fa-trash"></i></a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Checkbox Label:</label>
                                <input name="fields[{id}][label]" type="text" class="form-control"
                                    placeholder="Label" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Checkbox Name: *</label>
                                <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Data Type: </label>
                                <select name="fields[{id}][data_type]" class="form-select">
                                    <option value="boolean" selected>Boolean</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 properties">
                        <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                            <h6 class="mb-1">Properties</h6>
                            <span class="btn btn-outline-success border-0 rounded-0" onclick="addAttributeField(this)">
                                <i class="fa fa-plus"></i> Add Attribute
                            </span>
                        </div>

                        <div id="" class="attributes col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Attribute
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeAttributeField($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][properties][attributes][]"
                                        class="form-control" value="id" />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="fields[{id}][properties][values][]"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="radiolist_field" class="block block-rounded m-1">
                <div class="block-header block-header-default p-2" role="button" onclick="toggleField(this)">
                    <h3 class="block-title text-secondary">
                        <a class="btn"><i class="fa fa-angle-up collapsible"></i></a>
                        Radio List
                    </h3>
                    <div class="d-flex">
                        <a class="btn btn-outline-danger border-0" onclick="removeField($(this))"><i
                                class="fa fa-trash"></i></a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Radio List Group Label:</label>
                                <input name="fields[{id}][label]" type="text" class="form-control"
                                    placeholder="Label" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Radio List Group Name: *</label>
                                <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Data Type: </label>
                                <select name="fields[{id}][data_type]" class="form-select">
                                    <option value="enum" selected>Enum</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 radiolist_items">
                        <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                            <h6 class="mb-1">Radio List Items</h6>
                            <span class="btn btn-outline-success border-0 rounded-0" onclick="addRadioListItem(this)">
                                <i class="fa fa-plus"></i> Add Radio List Item
                            </span>
                        </div>

                        <div class="radiolist_item col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Radio Label: *
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeRadioListItem($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][items][labels][]" class="form-control"
                                        disabled required />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Radio Value: *</label>
                                    <input type="text" name="fields[{id}][items][values][]" class="form-control"
                                        disabled required />
                                </div>
                            </div>
                        </div>

                        <div class="radiolist_item col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Radio Label: *
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeRadioListItem($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][items][labels][]" class="form-control"
                                        disabled required />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Radio Value: *</label>
                                    <input type="text" name="fields[{id}][items][values][]" class="form-control"
                                        disabled required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 properties">
                        <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                            <h6 class="mb-1">Properties</h6>
                            <span class="btn btn-outline-success border-0 rounded-0" onclick="addAttributeField(this)">
                                <i class="fa fa-plus"></i> Add Attribute
                            </span>
                        </div>

                        <div id="" class="attributes col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Attribute
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeAttributeField($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][properties][attributes][]"
                                        class="form-control" value="id" />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="fields[{id}][properties][values][]"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="radiolist_item_template" class="radiolist_item col-lg-3 col-md-4 col-sm-6">
                <div class="row">
                    <div class="col-12 mt-1 form-group">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            Radio Label: *
                            <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                onclick="removeRadioListItem($(this))">
                                <i class="fa fa-minus"></i>
                            </span>
                        </label>
                        <input type="text" name="fields[{id}][items][labels][]" class="form-control" disabled
                            required />
                    </div>
                    <div class="col-12 mt-1 form-group">
                        <label class="form-label">Radio Value: *</label>
                        <input type="text" name="fields[{id}][items][values][]" class="form-control" disabled
                            required />
                    </div>
                </div>
            </div>

            <div id="fileupload_field" class="block block-rounded m-1">
                <div class="block-header block-header-default p-2" role="button" onclick="toggleField(this)">
                    <h3 class="block-title text-secondary">
                        <a class="btn"><i class="fa fa-angle-up collapsible"></i></a>
                        File Upload
                    </h3>
                    <div class="d-flex">
                        <a class="btn btn-outline-danger border-0" onclick="removeField($(this))"><i
                                class="fa fa-trash"></i></a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">File Upload Label: *</label>
                                <input name="fields[{id}][label]" type="text" class="form-control"
                                    placeholder="Label" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">File Upload Name: *</label>
                                <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Data Type: </label>
                                <select name="fields[{id}][data_type]" class="form-select">
                                    <option value="any" selected>Any</option>
                                    <option value="image">Image (png, jpg, svg)</option>
                                    <option value="video">Video (mp4, flv, wmv, mov)</option>
                                    <option value="document">Document (csv, xlsx, json)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1 align-self-center">
                            <div class="form-check form-switch">
                                <label class="form-check-label">Multiple Files</label>
                                <input class="form-check-input" name="fields[{id}][multiple]" type="checkbox">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 properties">
                        <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                            <h6 class="mb-1">Properties</h6>
                            <span class="btn btn-outline-success border-0 rounded-0" onclick="addAttributeField(this)">
                                <i class="fa fa-plus"></i> Add Attribute
                            </span>
                        </div>

                        <div id="" class="attributes col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Attribute
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeAttributeField($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][properties][attributes][]"
                                        class="form-control" value="id" />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="fields[{id}][properties][values][]"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="select_field" class="block block-rounded m-1">
                <div class="block-header block-header-default p-2" role="button" onclick="toggleField(this)">
                    <h3 class="block-title text-secondary">
                        <a class="btn"><i class="fa fa-angle-up collapsible"></i></a>
                        Select
                    </h3>
                    <div class="d-flex">
                        <a class="btn btn-outline-danger border-0" onclick="removeField($(this))"><i
                                class="fa fa-trash"></i></a>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Select Label:</label>
                                <input name="fields[{id}][label]" type="text" class="form-control"
                                    placeholder="Label" />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Select Name: *</label>
                                <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                    required />
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mt-1">
                            <div class="form-group">
                                <label class="form-label">Data Type: </label>
                                <select name="fields[{id}][data_type]" class="form-select">
                                    <option value="enum" selected>Enum</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 select_options">
                        <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                            <h6 class="mb-1">Options</h6>
                            <span class="btn btn-outline-success border-0 rounded-0" onclick="addOption(this)">
                                <i class="fa fa-plus"></i> Add Options
                            </span>
                        </div>

                        <div class="select_option col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Option Label: *
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeOption($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][options][labels][]" class="form-control"
                                        disabled required />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Option Value: *</label>
                                    <input type="text" name="fields[{id}][options][values][]" class="form-control"
                                        disabled required />
                                </div>
                            </div>
                        </div>

                        <div class="select_option col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Option Label: *
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeOption($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][options][labels][]" class="form-control"
                                        disabled required />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Option Value : *</label>
                                    <input type="text" name="fields[{id}][options][values][]" class="form-control"
                                        disabled required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 properties">
                        <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                            <h6 class="mb-1">Properties</h6>
                            <span class="btn btn-outline-success border-0 rounded-0" onclick="addAttributeField(this)">
                                <i class="fa fa-plus"></i> Add Attribute
                            </span>
                        </div>

                        <div id="" class="attributes col-lg-3 col-md-4 col-sm-6">
                            <div class="row">
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        Attribute
                                        <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                            onclick="removeAttributeField($(this))">
                                            <i class="fa fa-minus"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="fields[{id}][properties][attributes][]"
                                        class="form-control" value="id" />
                                </div>
                                <div class="col-12 mt-1 form-group">
                                    <label class="form-label">Value</label>
                                    <input type="text" name="fields[{id}][properties][values][]"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="select_option_template" class="select_option col-lg-3 col-md-4 col-sm-6">
                <div class="row">
                    <div class="col-12 mt-1 form-group">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            Option Label: *
                            <span class="btn btn-outline-danger border-0 ms-2 float-end" onclick="removeOption($(this))">
                                <i class="fa fa-minus"></i>
                            </span>
                        </label>
                        <input type="text" name="fields[{id}][options][labels][]" class="form-control" disabled required />
                    </div>
                    <div class="col-12 mt-1 form-group">
                        <label class="form-label">Option Value: *</label>
                        <input type="text" name="fields[{id}][options][values][]" class="form-control" disabled required />
                    </div>
                </div>
            </div>

            <div id="attribute_template" class="attributes col-lg-3 col-md-4 col-sm-6">
                <div class="row">
                    <div class="col-12 mt-1 form-group">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            Attribute
                            <span class="btn btn-outline-danger border-0 ms-2 float-end"
                                onclick="removeAttributeField($(this))">
                                <i class="fa fa-minus"></i>
                            </span>
                        </label>
                        <input type="text" name="fields[{id}][properties][attributes][]" class="form-control"
                            disabled />
                    </div>
                    <div class="col-12 mt-1 form-group">
                        <label class="form-label">Value</label>
                        <input type="text" name="fields[{id}][properties][values][]" class="form-control" disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        let fieldsDiv = $('#fields');
        let fields = [];
        let field_count = 0;
        $(function() {

        })

        function addField() {
            let selected_field_type = $('#field_types').val();
            switch (selected_field_type) {
                case "textbox":
                    addTextbox();
                    break;
                case "checkbox":
                    addCheckbox();
                    break;
                case "radiolist":
                    addRadioList();
                    break;
                case "radiolist":
                    addRadioList();
                    break;
                case "select":
                    addSelect();
                    break;
                case "fileupload":
                    addFileupload();
                    break;
                default:
                    break;
            }
        }

        function addTextbox() {
            let id = 'textbox-' + ++field_count;
            let template = $('#textbox_field').clone(false).attr('id', id).addClass('fields');
            $(template).find('[name="fields[{id}][label]"]').attr('name', `fields[${id}][label]`);
            $(template).find('[name="fields[{id}][name]"]').attr('name', `fields[${id}][name]`);
            $(template).find('[name="fields[{id}][data_type]"]').attr('name', `fields[${id}][data_type]`);
            $(template).find('[name="fields[{id}][multiple]"]').attr('name', `fields[${id}][multiple]`);
            $(template).find('[name="fields[{id}][properties][attributes][]"]').attr('name',
                `fields[${id}][properties][attributes][]`);
            $(template).find('[name="fields[{id}][properties][values][]"]').attr('name',
                `fields[${id}][properties][values][]`);
            fieldsDiv.prepend(template);
            fields.push(id);
        }

        function addCheckbox() {
            let id = 'checkbox-' + ++field_count;
            let template = $('#checkbox_field').clone(false).attr('id', id).addClass('fields');
            $(template).find('[name="fields[{id}][label]"]').attr('name', `fields[${id}][label]`);
            $(template).find('[name="fields[{id}][name]"]').attr('name', `fields[${id}][name]`);
            $(template).find('[name="fields[{id}][data_type]"]').attr('name', `fields[${id}][data_type]`);
            $(template).find('[name="fields[{id}][properties][attributes][]"]').attr('name',
                `fields[${id}][properties][attributes][]`);
            $(template).find('[name="fields[{id}][properties][values][]"]').attr('name',
                `fields[${id}][properties][values][]`);
            fieldsDiv.prepend(template);
            fields.push(id);
        }

        function addRadioList() {
            let id = 'radiolist-' + ++field_count;
            let template = $('#radiolist_field').clone(false).attr('id', id).addClass('fields');
            $(template).find('[name="fields[{id}][label]"]').attr('name', `fields[${id}][label]`);
            $(template).find('[name="fields[{id}][name]"]').attr('name', `fields[${id}][name]`);
            $(template).find('[name="fields[{id}][items][labels][]"]').attr('name', `fields[${id}][items][labels][]`).prop(
                'disabled', false);;
            $(template).find('[name="fields[{id}][items][values][]"]').attr('name', `fields[${id}][items][values][]`).prop(
                'disabled', false);;
            $(template).find('[name="fields[{id}][data_type]"]').attr('name', `fields[${id}][data_type]`);
            $(template).find('[name="fields[{id}][properties][attributes][]"]').attr('name',
                `fields[${id}][properties][attributes][]`);
            $(template).find('[name="fields[{id}][properties][values][]"]').attr('name',
                `fields[${id}][properties][values][]`);
            fieldsDiv.prepend(template);
            fields.push(id);
        }

        function addRadioListItem(element) {
            let template = $('#radiolist_item_template').clone(false).removeAttr('id');
            let field_id = $(element).closest('.fields').attr('id');
            $(template).find('input[name="fields[{id}][items][labels][]"]').attr('name',
                `fields[${field_id}][items][labels][]`).prop('disabled', false);
            $(template).find('input[name="fields[{id}][items][values][]"]').attr('name',
                `fields[${field_id}][items][values][]`).prop('disabled', false);
            $(template).appendTo($(element).closest('.radiolist_items'));
        }

        function removeRadioListItem(element) {
            $(element).closest('.radiolist_item').remove();
        }

        function addSelect() {
            let id = 'select-' + ++field_count;
            let template = $('#select_field').clone(false).attr('id', id).addClass('fields');
            $(template).find('[name="fields[{id}][label]"]').attr('name', `fields[${id}][label]`);
            $(template).find('[name="fields[{id}][name]"]').attr('name', `fields[${id}][name]`);
            $(template).find('[name="fields[{id}][options][labels][]"]').attr('name', `fields[${id}][options][labels][]`)
                .prop(
                    'disabled', false);;
            $(template).find('[name="fields[{id}][options][values][]"]').attr('name', `fields[${id}][options][values][]`)
                .prop(
                    'disabled', false);;
            $(template).find('[name="fields[{id}][data_type]"]').attr('name', `fields[${id}][data_type]`);
            $(template).find('[name="fields[{id}][properties][attributes][]"]').attr('name',
                `fields[${id}][properties][attributes][]`);
            $(template).find('[name="fields[{id}][properties][values][]"]').attr('name',
                `fields[${id}][properties][values][]`);
            fieldsDiv.prepend(template);
            fields.push(id);
        }

        function addOption(element) {
            let template = $('#select_option_template').clone(false).removeAttr('id');
            let field_id = $(element).closest('.fields').attr('id');
            $(template).find('input[name="fields[{id}][options][labels][]"]').attr('name',
                `fields[${field_id}][options][labels][]`).prop('disabled', false);
            $(template).find('input[name="fields[{id}][options][values][]"]').attr('name',
                `fields[${field_id}][options][values][]`).prop('disabled', false);
            $(template).appendTo($(element).closest('.select_options'));
        }

        function removeOption(element) {
            $(element).closest('.select_option').remove();
        }

        function addFileupload() {
            let id = 'fileupload-' + ++field_count;
            let template = $('#fileupload_field').clone(false).attr('id', id).addClass('fields');
            $(template).find('[name="fields[{id}][label]"]').attr('name', `fields[${id}][label]`);
            $(template).find('[name="fields[{id}][name]"]').attr('name', `fields[${id}][name]`);
            $(template).find('[name="fields[{id}][data_type]"]').attr('name', `fields[${id}][data_type]`);
            $(template).find('[name="fields[{id}][multiple]"]').attr('name', `fields[${id}][multiple]`);
            $(template).find('[name="fields[{id}][properties][attributes][]"]').attr('name',
                `fields[${id}][properties][attributes][]`);
            $(template).find('[name="fields[{id}][properties][values][]"]').attr('name',
                `fields[${id}][properties][values][]`);
            fieldsDiv.prepend(template);
            fields.push(id);
        }

        function removeField(element) {
            console.log('removeField');
            event.stopPropagation();
            $(element).closest('.fields').remove();
        }

        function toggleField(element) {
            console.log('toggleField');
            $(element).find('.collapsible').toggleClass('fa-angle-up').toggleClass('fa-angle-down');
            $(element).closest('.block').find('.block-content').toggle();

        }

        function addAttributeField(element) {
            let template = $('#attribute_template').clone(false).removeAttr('id');
            let field_id = $(element).closest('.fields').attr('id');
            $(template).find('input[name="fields[{id}][properties][attributes][]"]').attr('name',
                `fields[${field_id}][properties][attributes][]`).prop('disabled', false);
            $(template).find('input[name="fields[{id}][properties][values][]"]').attr('name',
                `fields[${field_id}][properties][values][]`).prop('disabled', false);
            $(template).appendTo($(element).closest('.properties'));
        }

        function removeAttributeField(element) {
            $(element).closest('.attributes').remove();
        }
    </script>
@endsection
