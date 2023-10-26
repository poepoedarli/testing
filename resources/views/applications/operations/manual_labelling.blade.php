<div class="row">
    <div class="block">
        <div class="block-content block-content-full p-0">
            @php
                $task = $parameters['task'];
                $reference = $parameters['reference'];
            @endphp
            <div class="row">
                <div class="col-7">
                    <div class="row items-push">
                        <div class="col-12 d-flex justify-content-between">
                            <div>
                                <a class="btn btn-sm btn-secondary"
                                    href="{{ route('adc_pcb.tasks', [$application->id]) }}">Tasks</a>
                                <a class="btn btn-sm btn-secondary"
                                    href="{{ route('adc_pcb.report', [$application->id, $task->id]) }}">Report</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <table aria-describedby="mydesc" class="table table-borderless table-striped">
                                <tbody>
                                    <tr>
                                        <th class="fw-medium text-muted">
                                            {{ $task->dataset->type }}
                                        </th>
                                        <th class="fw-medium text-muted">
                                            {{ $task->dataset->data_path }}
                                        </th>
                                    </tr>
                                    @if (!is_null($task->dataset_template_data))
                                        @foreach (json_decode($task->dataset_template_data) as $key => $value)
                                            <tr>
                                                <td class="fw-medium text-muted">
                                                    [{{ $key }}]
                                                </td>
                                                <td class="fw-medium text-muted"> {{ $value }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12">
                            <div class="progress position-relative">
                                <div class="progress-bar" role="progressbar" id="progressBar" style="width: 0%;"></div>
                                <small class="justify-content-center d-flex position-absolute w-100"
                                    id="progressLbl"></small>
                            </div>
                        </div>
                    </div>

                    <div id="results" class="row align-items-center items-push" style="display: none">
                        <div class="col-12">
                            <span class="fs-5 fw-semibold"> Manual Labelling </span> <span id="img_name"
                                class="ms-2 fs-sm text-muted"></span>
                        </div>

                        <div class="col-10">
                            <table aria-describedby="mydesc" class="table table-sm table-borderless table-striped" style="table-layout: fixed;">
                                <tbody>
                                    <tr class="fw-semibold">
                                        <td colspan="2">Manual</td>
                                        <td>AI</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <label class="form-label fw-semibold">Result:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="result"
                                                    id="resultG" value="G">
                                                <label class="form-check-label" for="resultG">
                                                    G
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="result"
                                                    id="resultNG" value="NG">
                                                <label class="form-check-label" for="resultNG">
                                                    NG
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="form-label text-muted" id="aiResult"></label>
                                        </td>
                                    </tr>
                                    {{-- <tr class="fw-semibold">
                                        <td colspan="3">Defect Classification:</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input class="form-control form-control-sm borderless"
                                                list="classificationOptions" id="code"
                                                placeholder="Select/Enter Classification">
                                            <datalist id="classificationOptions">
                                                <option value="Bubbles">
                                                <option value="Mushroom Defect">
                                                <option value="Oxidation">
                                                <option value="Resist Residue">
                                            </datalist>
                                        </td>
                                        <td>
                                            <label class="form-label text-muted" id="aiCode"></label>
                                        </td>
                                    </tr> --}}
                                    <tr class="fs-semibold">
                                        <td colspan="3">Remarks: </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <input type="text" class="form-control form-control-sm" placeholder=""
                                                id="remarks" name="remarks">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="submit" class="btn btn-primary" value="Submit"
                                                id="submit" />
                                        </td>
                                        <td>
                                            <label class="form-label text-muted fs-sm p-0 m-0" id="lastUpdated"></label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- Image Grid --}}
                <div class="col-5">
                    <div class="d-block" style="width: 420px">
                        <div class="row mb-2">
                            <div class="d-flex align-items-center justify-content-between p-0">
                                <span class="fs-5 fw-semibold">Image: {{ $reference->img_name }} </span>
                                <div>
                                    <a class="btn btn-sm btn-dark" id="magnifier">
                                        <i class="fa fa-magnifying-glass"></i> <span>On</span>
                                    </a>
                                    <a class="btn btn-sm btn-primary @disabled(is_null($parameters['prev_id']))"
                                        href="{{ route('adc_pcb.manual_labelling', [$application->id, $task->id, $parameters['prev_id']]) }}">
                                        <i class="fa fa-caret-left"></i> Prev
                                    </a>
                                    <a class="btn btn-sm btn-primary @disabled(is_null($parameters['next_id']))"
                                        href="{{ route('adc_pcb.manual_labelling', [$application->id, $task->id, $parameters['next_id']]) }}">
                                        Next <i class="fa fa-caret-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 d-none">
                            <div class="d-flex justify-content-end p-0">
                                <span class="me-2">Highlight: </span>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="highlightResults"
                                        onclick="offHighlight()" checked>
                                    <label class="form-check-label">
                                        Off
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="highlightResults"
                                        onclick="highlightG()">
                                    <label class="form-check-label">
                                        G
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="highlightResults"
                                        onclick="highlightNG()">
                                    <label class="form-check-label">
                                        NG
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($reference->results as $key => $value)
                                <div class="col-md-2 p-0 zoom-image-parent">
                                    <img alt="" class="zoom-image" id="box{{ $value['id'] }}" as='image'
                                        rel='preload' loading="lazy"
                                        src="{{ env('FILE_SERVER_DOMAIN', 'https://wavelengthblob.file.core.windows.net/') . $value['img_path'] . env('FILE_SERVER_SECRET_KEY', '?sv=2022-11-02&st=2023-08-16T07%3A40%3A45Z&se=2024-08-17T07%3A40%3A00Z&sr=s&sp=rl&sig=bxUw7R9IYysOnDNYY%2Bak9pCTIB4qY1iNuMfBVHqVxUM%3D') }}"
                                        onclick="viewResult({{ $key }})" />
                                    <div class="zoom-image-overlay">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <table aria-describedby="mydesc" class="table table-bordered table-striped table-vcenter " id="results-dtable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>AI Result</th>
                    <th>Label Result</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    var table;
    let results = @json($reference->results);
    var magnify = true;
    var selectedIndex = -1;
    $(function() {
        initMagnify();
        console.log('results', results)

        $('input[type=radio][name=result]').change(function() {
            if (this.value == 'G') {
                $('#code').attr('disabled', true);
            } else if (this.value == 'NG') {
                $('#code').attr('disabled', false);
            }
            $('#submit').attr('disabled', false);
        });

        $('input#code').on('input', function() {
            $('#submit').attr('disabled', false);
        });

        $('#submit').on('click', function() {
            if (selectedIndex < 0 && typeof results?.[selectedIndex] == undefined) {
                alert('An Error Occured, Please Try Again')
                window.location.reload(false);
                return false;
            }

            const {
                id
            } = results[selectedIndex];

            let form = {
                id: id,
                result: null,
                code: null,
                remarks: null
            };

            let formResult = $('input[name="result"]:checked').val().toUpperCase(),
                formCode = '' // $('input#code').val(),
            formRemarks = $('input#remarks').val();
            switch (formResult) {
                case 'G':
                    form.result = 'G';
                    break;
                case 'NG':
                    form.result = 'NG';
                    if (formCode.trim() == '') {
                        // alert('Specify Defect Classification for Result NG');
                        // return false;
                    }
                    form.code = formCode;
                    break;
                default:
                    alert('Unidentified Result');
                    return false;
                    break;
            }

            form.remarks = formRemarks.trim();

            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: "{{ route('adc_pcb.update_manual_labelling', [$application->id, $task->id, $reference->id]) }}",
                type: 'POST',
                DataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': "application/json"
                },
                data: {
                    "_token": token,
                    ...form
                },
                success: function(response) {
                    console.log('response', response);
                    if (response.success) {
                        const {
                            result
                        } = response;
                        let index = results.map(r => r.id).indexOf(result.id);
                        results[index] = result;
                        alert('Result Updated')
                        selectedIndex = -1;
                        viewResult(index)
                        table.draw(false);
                        updateProgress();
                    } else {
                        alert('Error Updating Result');
                    }
                }
            });
        });

        initResultsTable();
        updateProgress();
    })

    function updateProgress() {
        let progress = 0;
        let done = results.filter((r) => r.label_result !== null).length,
            total = results.length;

        progress = Math.round(done / total * 100);
        let barClass = 'bg-primary';
        if (progress >= 100) {
            barClass = "bg-success";
            progress = 100;
        } else if (progress >= 50) {
            barClass = "bg-warning";
        }

        $('#progressBar').attr('class', `progress-bar ${barClass}`);
        $('#progressLbl').text(`Labelled: ${done}/${total}`);
        $('#progressBar').css('width', `${progress}%`);
    }

    function initMagnify() {
        $('.zoom-image-parent').each(function() {
            //document.addEventListener('DOMContentLoaded', function () {
            var img1 = $(this).find('.zoom-image');
            var src1 = img1.attr('src');
            var img2 = $(this).find('.zoom-image-overlay');
            img2[0].style.backgroundImage = "url('" + src1 + "')";


            $(this).on('mousemove', function(e) {
                let original = img1[0],
                    magnified = img2[0],
                    style = magnified.style,
                    x = e.pageX - this.offsetLeft,
                    y = e.pageY - this.offsetTop,
                    imgWidth = original.offsetWidth,
                    imgHeight = original.offsetHeight,
                    xperc = ((x / imgWidth) * 100),
                    yperc = ((y / imgHeight) * 100);


                //lets user scroll past right edge of image
                if (x > (.01 * imgWidth)) {
                    xperc += (.15 * xperc);
                };

                //lets user scroll past bottom edge of image
                if (y >= (.01 * imgHeight)) {
                    yperc += (.15 * yperc);
                };

                style.backgroundPositionX = (xperc - 9) + '%';
                style.backgroundPositionY = (yperc - 9) + '%';

                style.left = (x - 180) + 'px';
                style.top = (y - 180) + 'px';
            });

        });


        $("#magnifier").on('click', function() {
            magnify = !magnify;
            $(this).toggleClass('btn-dark').toggleClass('btn-light');
            let text = magnify ? 'On' : 'Off';
            $(this).find('span').text(text);
            $('.zoom-image-overlay').each((i, element) => {
                $(element).toggleClass('d-none').toggleClass('d-block')
            });
            $('.zoom-image-parent').each((i, element) => {
                let cursor = magnify ? 'zoom-in' : 'pointer';
                $(element).css('cursor', cursor);
            })
        });
    }

    function viewResult(index) {
        if (index == selectedIndex) {
            deselect();
            return;
        }
        selectedIndex = index;
        const {
            id,
            img_path,
            ai_result,
            ai_code,
            label_code,
            label_result,
            updated_at,
            remarks
        } = results[index];
        highlightSelected(id);
        let txtCode = label_code ?? ai_code;
        let rbResult = label_result ?? ai_result;

        $('#img_name').text(img_path);
        $('#aiCode').text(ai_code);
        $('#aiResult').text(ai_result);
        $('#lastUpdated').html(`Last Updated at <br/> ${updated_at}`);
        $('#remarks').val(remarks);

        switch (rbResult) {
            case 'G':
            default:
                $('#resultG').prop('checked', true);
                $('#code').attr('disabled', true).val('');
                break;
            case 'NG':
                $('#resultNG').prop('checked', true);
                $('#code').attr('disabled', false).val(txtCode);
                break;
        }
        // $('#submit').attr('disabled', true);
        $('#results').hide().fadeIn();
    }

    function initResultsTable() {
        const columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '15px'
            },
            {
                data: 'image',
                name: 'image',
                orderable: false,
            },
            {
                data: 'ai_result',
                name: 'adc_pcb_results.ai_result',
            },
            // {
            //     data: 'ai_code',
            //     name: 'adc_pcb_results.ai_code',
            // },
            {
                data: 'label_result',
                name: 'adc_pcb_results.label_result',
            },
            // {
            //     data: 'label_code',
            //     name: 'adc_pcb_results.label_code',
            // },
            {
                data: 'remarks',
                name: 'remarks',
            },
        ];
        const filterColumns = {
            "inputs": ["AI Result", "Label Result", "Remarks"],

        };
        const ajax_url = "{{ route('adc_pcb.results', [$application->id, $reference->id]) }}";
        const table_id = "results-dtable";
        setTimeout(() => {
            Custom.initDataTable(table_id, ajax_url, columns, filterColumns, null)
        }, 200);


        $('#' + table_id).on('click', '.dt-img', function() {
            let id = $(this).data().id;
            let index = results.map(r => r.id).indexOf(id);
            selectedIndex = -1;
            viewResult(index);

            $('html, body').animate({
                scrollTop: $("#results").offset().top - 250
            }, 0);
        });
    }

    function deselect() {
        console.log('deselect')
        $('#results').hide()
        selectedIndex = -1;
        highlightSelected(-1)
    }

    function highlightSelected(id) {
        let box_id = `#box${id}`;
        $('.zoom-image').css('border', '1px solid white');
        $(box_id).css('border', '1px solid blue');
    }

    function highlightG() {
        results.forEach(element => {
            const {
                id,
                result
            } = element;
            let box_id = `#box${id}`;
            if (result == 'G') {
                $(box_id).css('border', '2px solid green').show();

            } else {
                $(box_id).css('border', '1px solid white').hide();
            }
        });
    }

    function highlightNG() {
        results.forEach(element => {
            const {
                id,
                result
            } = element;
            let box_id = `#box${id}`;
            if (result == 'NG') {
                $(box_id).css('border', '2px solid red').show();
            } else {
                $(box_id).css('border', '1px solid white').hide();
            }
        });
    }

    function offHighlight() {
        results.forEach(element => {
            const {
                id
            } = element;
            let box_id = `#box${id}`;
            $(box_id).css('border', '1px solid white');
        });
    }
</script>

<style>
    .zoom-image-parent {
        max-width: 200px;
        height: auto;
        position: relative;
        margin: 0;
    }

    .zoom-image {
        width: 100%;
        height: auto;
        border: 1px solid white;
    }

    .zoom-image-parent:hover,
    .zoom-image-parent:active {
        cursor: zoom-in;
        display: block;
    }

    .zoom-image-parent:hover .zoom-image-overlay,
    .zoom-image-parent:active .zoom-image-overlay {
        opacity: 1;
    }

    .zoom-image-overlay {
        width: 200px;
        height: 200px;
        box-shadow: 0 5px 10px -2px rgba(0, 0, 0, 0.3);
        pointer-events: none;
        position: absolute;
        opacity: 0;
        border: 4px solid whitesmoke;
        z-index: 99;
        border-radius: 100%;
        display: block;
        transition: opacity .2s;
        background-repeat: no-repeat;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
</style>
