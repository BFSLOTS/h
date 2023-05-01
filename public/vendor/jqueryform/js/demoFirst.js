"use strict";
const newLocal = true;
jQuery(function ($) {
    var fields = [{
        type: 'autocomplete',
        label: 'Custom Autocomplete',
        required: true,
        values: [
            { label: 'SQL' },
            { label: 'C#' },
            { label: 'JavaScript' },
            { label: 'Java' },
            { label: 'Python' },
            { label: 'C++' },
            { label: 'PHP' },
            { label: 'Swift' },
            { label: 'Ruby' }
        ]
    },
    {
        label: 'Star Rating',
        attrs: {
            type: 'starRating',
            number_of_star: 5
        },
        icon: '🌟'
    }
    ];
    var actionButtons = [{
        id: 'smile',
        className: 'btn btn-success',
        label: '😁',
        type: 'button',
        events: {
            click: function () {
                alert('😁😁😁 !SMILE! 😁😁😁');
            }
        }
    }];
    var templates = {
        starRating: function (fieldData) {
            return {
                field: '<span id="' + fieldData.name + '">',
                onRender: function () {
                    $(document.getElementById(fieldData.name)).rateYo({ rating: fieldData.value, numStars: fieldData.number_of_star, halfStar: true, precision: 2 });
                }
            };
        }
    };
    var inputSets = [{
        label: 'User Details',
        icon: '👨',
        fields: [{
            type: 'text',
            label: 'First Name',
            className: 'form-control'
        }, {
            type: 'select',
            label: 'Profession',
            className: 'form-control',
            values: [{
                label: 'Street Sweeper',
                value: 'option-2',
                selected: false
            }, {
                label: 'Brain Surgeon',
                value: 'option-3',
                selected: false
            }]
        }, {
            type: 'textarea',
            label: 'Short Bio:',
            className: 'form-control'
        }]
    }, {
        label: 'User Agreement',
        fields: [{
            type: 'header',
            subtype: 'h3',
            label: 'Terms & Conditions',
            className: 'header'
        }, {
            type: 'paragraph',
            label: 'Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.',
        }, {
            type: 'paragraph',
            label: 'Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.',
        }, {
            type: 'checkbox',
            label: 'Do you agree to the terms and conditions?',
        }]
    }];
    var typeUserDisabledAttrs = {};
    var newAttributes = {
        column: {
            label: 'Columns',
            options: {
                '1': '1 Column',
                '2': '2 Column',
                '3': '3 Column',
            },
        }
    };
    var typeUserAttrs = {};
    const fieldss = ["autocomplete", "button", "checkbox-group", "file", "header", "paragraph", "date", "number", "radio-group", "select", "text", "textarea","starRating"];
    fieldss.forEach(function (item, index) {
        if (item == 'text') {
            typeUserAttrs[item] = {
                column: newAttributes.column, is_client_email: {
                    label: 'Is Client Email',
                    type: 'checkbox',
                    value: '1',
                }
            };
        }

            if (item == 'radio-group' || item == 'select' || item == 'checkbox-group' || item == 'date'|| item == 'select' || item == 'starRating') {
                typeUserAttrs[item] = {
                    column: newAttributes.column, is_enable_chart: {
                        label: 'Enable Chart',
                        type: 'checkbox',
                        value: false,
                    },
                    column: newAttributes.column, chart_type : {
                        label: 'Chart Type',
                        options: {
                            'bar': 'Bar',
                            'pie': 'Pie',
                        },
                    }
                };

        } else {
            typeUserAttrs[item] = newAttributes;
        }
    });
    var disabledSubtypes = { textarea: ["tinymce", "quill"] };
    var disabledAttrs = ['placeholder'];
    var fbOptions = {
        subtypes: {
            text: ['datetime-local', 'email'],
            textarea: ['ckeditor']
        },
        typeUserEvents: {
            text: {
                onadd: function (fld) {

                    var $patternField = $(".fld-is_client_email", fld);
                    var $patternField1 = $(".fld-is_enable_chart", fld);
                    var $patternWrap = $patternField.parents(".is_client_email-wrap:eq(0)");
                    var $patternWrap1 = $patternField1.parents(".is_enable_chart-wrap:eq(0)");
                    $patternField1.prop("checked", false);
                    var select = fld.querySelector(".fld-subtype");
                    if (select.value != "email") {
                        $patternWrap.hide();
                        $patternField.prop("checked", false);
                        $patternField.prop("disabled", true);
                    }
                    var val = $patternField.prop("checked") ? 1 : 0;
                    if (val == 1) {
                        $patternWrap.show();
                        $patternField.prop("checked", true);
                        $patternField.prop("disabled", false);
                    }
                    fld.querySelector(".fld-subtype").onchange = function (e) {
                        var toggle = e.target.value === "email";
                        if (e.target.value == 'email') {
                            $patternWrap.show(!toggle);
                            $patternField.prop("disabled", !toggle);
                            $patternField.prop("checked", !toggle);
                        } else {
                            $patternWrap.hide(!toggle);
                            $patternField.prop("disabled", !toggle);
                            $patternField.prop("checked", !toggle);
                        }
                    };
                }
            },
            select:{
                onadd: function (fld) {
                    
                    if($(fld).find('.fld-is_enable_chart').prop('checked') == false){
                        $(fld).find('.chart_type-wrap').hide();
                    }

                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        }else{
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });

                }
            },
            date:{
                onadd: function (fld) {

                    if($(fld).find('.fld-is_enable_chart').prop('checked') == false){
                        $(fld).find('.chart_type-wrap').hide();
                    }

                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        }else{
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });

                }
            },
            'checkbox-group':{
                onadd: function (fld) {

                     if($(fld).find('.fld-is_enable_chart').prop('checked') == false){
                        $(fld).find('.chart_type-wrap').hide();
                    }

                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        }else{
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
            'radio-group':{
                onadd: function (fld) {

                     if($(fld).find('.fld-is_enable_chart').prop('checked') == false){
                        $(fld).find('.chart_type-wrap').hide();
                    }

                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        }else{
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
            starRating:{
                onadd: function (fld) {

                    if($(fld).find('.fld-is_enable_chart').prop('checked') == false){
                        $(fld).find('.chart_type-wrap').hide();
                    }

                    $(document).on('change', ".fld-is_enable_chart", function () {
                        if (this.checked) {
                            $(this).parent().parent().parent().find('.chart_type-wrap').show();
                        }else{
                            $(this).parent().parent().parent().find('.chart_type-wrap').hide();
                        }
                    });
                }
            },
        },
        onSave: function (e, formData) {
            toggleEdit();
            $('.render-wrap').formRender({
                formData: formData,
                templates: templates
            });
            window.sessionStorage.setItem('formData', JSON.stringify(formData));
        },
        stickyControls: {
            enable: true
        },
        sortableControls: true,
        fields: fields,
        templates: templates,
        inputSets: inputSets,
        typeUserDisabledAttrs: typeUserDisabledAttrs,
        typeUserAttrs: typeUserAttrs,
        disableInjectedStyle: false,
        actionButtons: actionButtons,
        disableFields: [],
        disabledSubtypes: disabledSubtypes,
        disabledFieldButtons: {
            text: ['copy']
        }
    };


    var formData = window.sessionStorage.getItem('formData');
    var editing = true;
    if (formData) {
        fbOptions.formData = JSON.parse(formData);
    }
    function toggleEdit() {
        document.body.classList.toggle('form-rendered', editing);
        return editing = !editing;
    }
    var setFormData = $("input[name='json']").val();
    if (setFormData.length) {
        setFormData = JSON.parse(setFormData);
    }


    var fbPages = $(document.getElementById("design-form"));
    var addPageTab = document.getElementById("add-page-tab");
    var fbInstances = [];
    fbPages.tabs({
        beforeActivate: function (event, ui) {
            if (ui.newPanel.selector === "#new-page") {
                return false;
            }
        }
    });
    addPageTab.addEventListener(
        "click",
        (click) => {
            addPage([]);
        },
        false
    );
    function addPage(data) {
        const tabCount = document.getElementById("tabs").children.length;
        const tabId = "page" + tabCount.toString();
        const newPageTemplate = document.getElementById("new-page");
        const newTabTemplate = document.getElementById("add-page-tab");
        const newPage = newPageTemplate.cloneNode(true);
        newPage.setAttribute("id", tabId);
        newPage.classList.add("build-wrap");
        const $newTab = newTabTemplate.cloneNode(true);
        $newTab.removeAttribute("id");
        const tabLink = $newTab.querySelector("a");
        tabLink.setAttribute("href", "#" + tabId);
        tabLink.innerText = lang_Page + tabCount;
        newPageTemplate.parentElement.insertBefore(newPage, newPageTemplate);
        newTabTemplate.parentElement.insertBefore($newTab, newTabTemplate);
        fbPages.tabs("refresh");
        fbPages.tabs("option", "active", tabCount - 1);
        if (data.length) {
            fbOptions.formData = data;
        } else {
            fbOptions.formData = [];
        }
        var formbuilder = $(newPage).formBuilder(fbOptions);
        // setTimeout(function () {
        //     formbuilder.actions.setLang(lang);
        // }, 800);
        fbInstances.push(formbuilder);
    }
    // fbInstances.push($(".build-wrap").formBuilder(fbOptions));
    // setTimeout(function () {
    //     fbInstances[0].actions.setLang(lang);
    // }, 800);
    // $(document).ready(function () {
    //     setTimeout(function () {
    //         $.each(setFormData, function (i, item) {
    //             if (fbInstances[i]) {
    //                 fbInstances[i].actions.setData(item);
    //                 // fbInstances[i].actions.setLang(lang);
    //             } else {
    //                 addPage(item);
    //             }
    //         });
    //     }, 2000);
    // });
console.log(setFormData);

    var json = setFormData;
    if(json.length == 0) {
        fbInstances.push($("#page-1").formBuilder(fbOptions));
    }else {
        $(json).each(function (index, data) {
            setTimeout(function (){
                fbOptions.formData = data;
                fbInstances.push($("#page-"+(index+1)).formBuilder(fbOptions));
            },index*1000)
        })
    }

    $(document.getElementById("getJSON")).click(function () {
        const allData = fbInstances.map((fb) => {
            var json = fb.actions.getData('json', true);
            return json;
        });
        console.log(allData);
        $("input[name='json']").val("[" + allData + "]");
        $("#design-form").submit();
    });
});