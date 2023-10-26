<div id="builder">
    <div id="builder_control" class="block block-rounded mb-2">
        <div class="block-content block-content-full">
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
                    <a class="btn btn-outline-primary d-grid btn-sm" onclick="addField()">Add Field</a>
                </div>
            </div>
        </div>
    </div>

    <div id="fields" class="block">

    </div>

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
                            <input name="fields[{id}][label]" type="text" class="form-control" placeholder="Label"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Textbox Name: *</label>
                            <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Data Type: </label>
                            <select name="fields[{id}][data_type]" class="form-select" disabled>
                                <option value="string" selected>String</option>
                                <option value="number">Number</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1 align-self-center">
                        <div class="form-check form-switch">
                            <label class="form-check-label">Multi Line</label>
                            <input class="form-check-input" name="fields[{id}][multiple]" type="checkbox"
                                value="textarea" disabled>
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
                            <input name="fields[{id}][label]" type="text" class="form-control" placeholder="Label"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Checkbox Name: *</label>
                            <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Data Type: </label>
                            <select name="fields[{id}][data_type]" class="form-select" disabled>
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
                                placeholder="Label" disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Radio List Group Name: *</label>
                            <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Data Type: </label>
                            <select name="fields[{id}][data_type]" class="form-select" disabled>
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
                                    disabled />
                            </div>
                            <div class="col-12 mt-1 form-group">
                                <label class="form-label">Radio Value: *</label>
                                <input type="text" name="fields[{id}][items][values][]" class="form-control"
                                    disabled />
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
                                    disabled />
                            </div>
                            <div class="col-12 mt-1 form-group">
                                <label class="form-label">Radio Value: *</label>
                                <input type="text" name="fields[{id}][items][values][]" class="form-control"
                                    disabled />
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
                    <input type="text" name="fields[{id}][items][labels][]" class="form-control" disabled />
                </div>
                <div class="col-12 mt-1 form-group">
                    <label class="form-label">Radio Value: *</label>
                    <input type="text" name="fields[{id}][items][values][]" class="form-control" disabled />
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
                                placeholder="Label" disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">File Upload Name: *</label>
                            <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Data Type: </label>
                            <select name="fields[{id}][data_type]" class="form-select" disabled>
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
                            <input class="form-check-input" name="fields[{id}][multiple]" type="checkbox" disabled>
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
                                placeholder="Label" disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Select Name: *</label>
                            <input type="text" name="fields[{id}][name]" class="form-control" placeholder="Name"
                                disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mt-1">
                        <div class="form-group">
                            <label class="form-label">Data Type: </label>
                            <select name="fields[{id}][data_type]" class="form-select" disabled>
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

                </div>

                <div class="row mt-2 properties">
                    <div class="col-12 d-flex justify-content-between align-items-center border-top border-bottom">
                        <h6 class="mb-1">Properties</h6>
                        <span class="btn btn-outline-success border-0 rounded-0" onclick="addAttributeField(this)">
                            <i class="fa fa-plus"></i> Add Attribute
                        </span>
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
                    <input type="text" name="fields[{id}][options][labels][]" class="form-control" disabled />
                </div>
                <div class="col-12 mt-1 form-group">
                    <label class="form-label">Option Value: *</label>
                    <input type="text" name="fields[{id}][options][values][]" class="form-control" disabled />
                </div>
            </div>
        </div>

        <div id="attribute_template" class="attributes col-lg-3 col-md-4 col-sm-6">
            <div class="row">
                <div class="col-12 mt-1 form-group">
                    <label class="form-label d-flex justify-content-between align-items-center">
                        Attribute *
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
    let readonly = @json($viewonly);
    let existing_fields_json = @json($fields);
    let old_fields_json = @json(old('fields'));
    let fieldsDiv = $('#fields');
    let fields = []; // debug
    let field_count = 0; // id
    $(function() {
        if (old_fields_json && old_fields_json.length) {
            existing_fields_json = old_fields_json;
        }
        if (existing_fields_json && existing_fields_json.length) {
            existing_fields = JSON.parse(existing_fields_json);
            for (const [k, v] of Object.entries(existing_fields)) {
                let keys = k.split("-");
                const [control, index] = keys;
                let props = {
                    id: k,
                    ...v
                };
                switch (control) {
                    case "textbox":
                        addTextbox(props);
                        break;
                    case "checkbox":
                        addCheckbox(props);
                        break;
                    case "radiolist":
                        addRadioList(props);
                        break;
                    case "select":
                        addSelect(props);
                        break;
                    case "fileupload":
                        addFileupload(props);
                        break;
                    default:
                        console.log('Unidentified Control', control, k, props);
                        break;
                }
            }
        }

        if (readonly) {
            $('#builder_control').hide();
            $('#builder').css({
                'pointer-events': 'none'
            });
        }
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

    function addTextbox({
        id,
        label,
        name,
        data_type,
        multiple,
        properties
    } = {}) {
        id = 'textbox-' + ++field_count;
        let template = $('#textbox_field').clone(false).attr('id', id).addClass('fields');

        $(template).find('[name="fields[{id}][label]"]')
            .attr({
                'name': `fields[${id}][label]`,
                'value': label
            })
            .prop('disabled', false);

        $(template).find('[name="fields[{id}][name]"]')
            .attr({
                'name': `fields[${id}][name]`,
                'value': name
            })
            .prop({
                'disabled': false,
                'required': true
            });

        $(template).find('[name="fields[{id}][data_type]"]')
            .attr('name', `fields[${id}][data_type]`)
            .prop('disabled', false)
            .val(data_type);

        $(template).find('[name="fields[{id}][multiple]"]')
            .attr('name', `fields[${id}][multiple]`)
            .prop({
                'disabled': false,
                'checked': multiple
            });

        if (properties && properties.hasOwnProperty('attributes') && properties.attributes.length) {
            for (let i = 0; i < properties.attributes.length; i++) {
                addAttributeField($(template).find('.properties'), {
                    attribute: properties.attributes[i],
                    value: properties.values[i]
                })
            }
        } else {
            // set default properties
        }

        fieldsDiv.append(template);
        fields.push(id);
    }

    function addCheckbox({
        id,
        label,
        name,
        data_type,
        properties
    } = {}) {
        id = 'checkbox-' + ++field_count;
        let template = $('#checkbox_field').clone(false).attr('id', id).addClass('fields');

        $(template).find('[name="fields[{id}][label]"]')
            .attr({
                'name': `fields[${id}][label]`,
                'value': label
            })
            .prop('disabled', false);

        $(template).find('[name="fields[{id}][name]"]')
            .attr({
                'name': `fields[${id}][name]`,
                'value': name
            })
            .prop({
                'disabled': false,
                'required': true
            });

        $(template).find('[name="fields[{id}][data_type]"]')
            .attr('name', `fields[${id}][data_type]`)
            .prop('disabled', false)
            .val(data_type);

        if (properties && properties.hasOwnProperty('attributes') && properties.attributes.length) {
            for (let i = 0; i < properties.attributes.length; i++) {
                addAttributeField($(template).find('.properties'), {
                    attribute: properties.attributes[i],
                    value: properties.values[i]
                })
            }
        } else {
            // set default properties
        }

        fieldsDiv.append(template);
        fields.push(id);
    }

    function addRadioList({
        id,
        label,
        name,
        data_type,
        items,
        properties
    } = {}) {
        id = 'radiolist-' + ++field_count;
        let template = $('#radiolist_field').clone(false).attr('id', id).addClass('fields');

        $(template).find('[name="fields[{id}][label]"]')
            .attr({
                'name': `fields[${id}][label]`,
                'value': label
            })
            .prop('disabled', false);

        $(template).find('[name="fields[{id}][name]"]')
            .attr({
                'name': `fields[${id}][name]`,
                'value': name
            })
            .prop({
                'disabled': false,
                'required': true
            });

        $(template).find('[name="fields[{id}][data_type]"]')
            .attr('name', `fields[${id}][data_type]`)
            .prop('disabled', false)
            .val(data_type);

        if (items && items.hasOwnProperty('labels') && items.labels.length) {
            for (let i = 0; i < items.labels.length; i++) {
                addRadioListItem($(template).find('.radiolist_items'), {
                    attribute: items.labels[i],
                    value: items.values[i]
                })
            }
        } else {
            // set default items
        }

        if (properties && properties.hasOwnProperty('attributes') && properties.attributes.length) {
            for (let i = 0; i < properties.attributes.length; i++) {
                addAttributeField($(template).find('.properties'), {
                    attribute: properties.attributes[i],
                    value: properties.values[i]
                })
            }
        }

        fieldsDiv.append(template);
        fields.push(id);
    }

    function addRadioListItem(element, {
        label,
        value
    } = {}) {
        let template = $('#radiolist_item_template').clone(false).removeAttr('id');
        let field_id = $(element).closest('.fields').attr('id');

        $(template).find('input[name="fields[{id}][items][labels][]"]')
            .attr({
                'name': `fields[${field_id}][items][labels][]`,
                'value': label
            })
            .prop({
                'disabled': false,
                'required': true,
            });

        $(template).find('input[name="fields[{id}][items][values][]"]')
            .attr({
                'name': `fields[${field_id}][items][values][]`,
                'value': value
            })
            .prop({
                'disabled': false,
                'required': true,
            });

        $(template).appendTo($(element).closest('.radiolist_items'));
    }

    function removeRadioListItem(element) {
        $(element).closest('.radiolist_item').remove();
    }

    function addSelect({
        id,
        label,
        name,
        data_type,
        options,
        properties
    } = {}) {
        id = 'select-' + ++field_count;
        let template = $('#select_field').clone(false).attr('id', id).addClass('fields');

        $(template).find('[name="fields[{id}][label]"]')
            .attr({
                'name': `fields[${id}][label]`,
                'value': label
            })
            .prop('disabled', false);

        $(template).find('[name="fields[{id}][name]"]')
            .attr({
                'name': `fields[${id}][name]`,
                'value': name
            })
            .prop({
                'disabled': false,
                'required': true
            });

        $(template).find('[name="fields[{id}][data_type]"]')
            .attr('name', `fields[${id}][data_type]`)
            .prop('disabled', false)
            .val(data_type);

        if (options && options.hasOwnProperty('labels') && options.labels.length) {
            for (let i = 0; i < options.labels.length; i++) {
                addOption($(template).find('.select_options'), {
                    label: options.labels[i],
                    value: options.values[i]
                })
            }
        } else {
            // set default items
        }

        fieldsDiv.append(template);
        fields.push(id);
    }

    function addOption(element, {
        label,
        value
    } = {}) {
        let template = $('#select_option_template').clone(false).removeAttr('id');
        let field_id = $(element).closest('.fields').attr('id');
        $(template).find('[name="fields[{id}][options][labels][]"]')
            .attr({
                'name': `fields[${field_id}][options][labels][]`,
                'value': label
            })
            .prop({
                'disabled': false,
                'required': true,
            });
        $(template).find('[name="fields[{id}][options][values][]"]')
            .attr({
                'name': `fields[${field_id}][options][values][]`,
                'value': value
            })
            .prop({
                'disabled': false,
                'required': true,
            });

        $(template).appendTo($(element).closest('.select_options'));
    }

    function removeOption(element) {
        $(element).closest('.select_option').remove();
    }

    function addFileupload({
        id,
        label,
        name,
        data_type,
        multiple,
        properties
    } = {}) {
        id = 'fileupload-' + ++field_count;
        let template = $('#fileupload_field').clone(false).attr('id', id).addClass('fields');

        $(template).find('[name="fields[{id}][label]"]')
            .attr({
                'name': `fields[${id}][label]`,
                'value': label
            })
            .prop('disabled', false);

        $(template).find('[name="fields[{id}][name]"]')
            .attr({
                'name': `fields[${id}][name]`,
                'value': name
            })
            .prop({
                'disabled': false,
                'required': true
            });

        $(template).find('[name="fields[{id}][data_type]"]')
            .attr('name', `fields[${id}][data_type]`)
            .prop('disabled', false)
            .val(data_type);

        $(template).find('[name="fields[{id}][multiple]"]')
            .attr('name', `fields[${id}][multiple]`)
            .prop({
                'disabled': false,
                'checked': multiple
            });

        if (properties && properties.hasOwnProperty('attributes') && properties.attributes.length) {
            for (let i = 0; i < properties.attributes.length; i++) {
                addAttributeField($(template).find('.properties'), {
                    attribute: properties.attributes[i],
                    value: properties.values[i]
                })
            }
        } else {
            // set default properties
        }

        fieldsDiv.append(template);
        fields.push(id);
    }

    function removeField(element) {
        event.stopPropagation();
        $(element).closest('.fields').remove();
    }

    function toggleField(element) {
        $(element).find('.collapsible').toggleClass('fa-angle-up').toggleClass('fa-angle-down');
        $(element).closest('.block').find('.block-content').toggle();
    }

    function addAttributeField(element, {
        attribute,
        value
    } = {}) {
        let template = $('#attribute_template').clone(false).removeAttr('id');
        let field_id = $(element).closest('.fields').attr('id');
        $(template).find('input[name="fields[{id}][properties][attributes][]"]')
            .attr({
                'name': `fields[${field_id}][properties][attributes][]`,
                'value': attribute
            })
            .prop({
                'disabled': false,
                'required': true,
            });
        $(template).find('input[name="fields[{id}][properties][values][]"]')
            .attr({
                'name': `fields[${field_id}][properties][values][]`,
                'value': value
            })
            .prop({
                'disabled': false,
            });
        $(template).appendTo($(element).closest('.properties'));
    }

    function removeAttributeField(element) {
        $(element).closest('.attributes').remove();
    }
</script>
