@extends('layouts.main')
@section('content')
    <script>
        function showActivityDetails(el, data) {
            $('#json-renderer').jsonViewer(JSON.parse(data));
            $('#modalShowActDetails').modal('show');
        }

        function showConfirmation(el, mode) {
            var item = jQuery(el);
            $('#modalBtn').removeClass('btn-danger');
            $('#modalBtn').removeClass('btn-success');
            // $('#modalUsername').html(item.data('username'));
            // $('#modalMethod').html(item.data('method'));
            // $('#modalDue').html(item.data('due'));
            // $('#modalRef').html(item.data('reference'));
            $('#modalId').val(item.data('id'));
            $("#modalList").html('');

            $.each(item.data('attributes'), function(i, obj) {
                var list = $('<li/>');
                list.attr('class', 'list-group-item');
                list.html(i);

                var span = $('<span/>');
                span.attr('class', 'float-right font-weight-bold');
                span.html(obj)
                span.appendTo(list);
                $("#modalList").append(list);
            });

            switch (mode) {
                case 'topup_delete':
                    $('#modalMode').val('topup');
                    $('#modalAction').val(0);
                    $('#modalText').html('Are you sure you want to disapprove the following transaction?');
                    $('#modalBtn').html('Disapprove');
                    $('#modalBtn').addClass('btn-danger');
                    $('#modalConfirmation').modal('show');
                    break;
                case 'topup_add':
                    $('#modalMode').val('topup');
                    $('#modalAction').val(1);
                    $('#modalText').html('Are you sure you want to approve the following transaction?');
                    $('#modalBtn').html('Approve');
                    $('#modalBtn').addClass('btn-success');
                    $('#modalConfirmation').modal('show');
                    break;
                case 'itemmall_delete':
                    $('#modalMode').val('malleditor');
                    $('#modalAction').val(0);
                    $('#modalText').html('Are you sure you want to remove the following item from shop?');
                    $('#modalBtn').html('Remove');
                    $('#modalBtn').addClass('btn-danger');
                    $('#modalConfirmation').modal('show');
                    break;
                case 'referrals_delete':
                    $('#modalMode').val('partnereditor');
                    $('#modalAction').val(0);
                    $('#modalText').html('Are you sure you want to revoke the partnership?');
                    $('#modalBtn').html('Revoke');
                    $('#modalBtn').addClass('btn-danger');
                    $('#modalConfirmation').modal('show');
                    break;
                case 'tier_delete':
                    $('#modalMode').val('tiereditor');
                    $('#modalAction').val(0);
                    $('#modalText').html('Are you sure you want to delete the tier?');
                    $('#modalBtn').html('Delete');
                    $('#modalBtn').addClass('btn-danger');
                    $('#modalConfirmation').modal('show');
                    break;
                case 'reset_tier':
                    $('#modalMode').val('tiereditor');
                    $('#modalAction').val(3);
                    $('#modalText').html('Are you sure you want to reset all tier?<br/>This will remove all tier rewards.');
                    $('#modalBtn').html('Reset');
                    $('#modalBtn').addClass('btn-danger');
                    $('#modalConfirmation').modal('show');
                    break;
                case 'redeem_delete':
                    $('#modalMode').val('redeemeditor');
                    $('#modalAction').val(0);
                    $('#modalText').html('Are you sure you want to remove the redeem code?');
                    $('#modalBtn').html('Remove');
                    $('#modalBtn').addClass('btn-danger');
                    $('#modalConfirmation').modal('show');
                    break;
                case 'item_add':
                    var option = parseInt($('input[name="delivery_option"]:checked').val());

                    if (!$('#itemDeliveryItemID').val()
                        || (option == 0 && !$('#itemDeliveryName').val())
                        || (option == 1 && $("#itemDeliveryName").tagsinput('items').length == 0)) {

                        $('#modal').modal('show');
                        $('#modal .modal-title').html('Field Empty');
                        $('#modal .modal-body').html('Please fill in the required inputs.');
                        break;
                    }

                    $('#modalAction').val(option);
                    $('#modalMode').val('itemdelivery');
                    $('#modalText').html('Are you sure you want to send the following item?');
                    $('#modalBtn').html('Send');
                    $('#modalBtn').addClass('btn-success');

                    switch(option) {
                        case 1:
                            $('#modalId').val(JSON.stringify($("#itemDeliveryName").tagsinput('items')));
                            break;
                        case 2:
                            $('#modalId').val(-1);
                            break;
                    }

                    $("#modalItemId").val($("#itemDeliveryItemID").val());
                    $("#modalItemQty").val($("#itemDeliveryItemQty").val());
                    $('#modalConfirmation').modal('show');
                    break;
            }
        }

        function showItemEditor(el, mode) {
            var item = jQuery(el);
            $('#modalItemEditorMode').val(mode);
            $('#modalItemEditorErrorWrapper').hide();
            resetSubItems();
            switch(mode) {
                case 0:
                    $('#modalItemDeletionID').html(item.data('itemid'));
                    $('#modalItemDeletionID_2').val(item.data('itemid'));
                    $('#modalItemDeletionName').html(item.data('name'));
                    $('#modalItemDeletionCategory').html(item.data('category'));
                    $('#modalItemDeletionPrice').html(item.data('price'));
                    $('#modalItemDeletion').modal('show');
                    break;
                case 1:
                    $('#modalItemEditorTitle').html('Add Item');
                    $('#modalItemEditorAction').html('Submit');

                    $('#modalItemEditorName').val('');
                    $('#modalItemEditorDesc').html('');
                    $('#modalItemEditorEffects').tagsinput('removeAll');
                    $('#modalItemEditorId').val('');
                    $('#modalItemEditorQty').val(1);
                    $('#modalItemEditorCategory').val(0);
                    $('#modalItemEditorPrice').val(0);
                    $('#modalItemEditorImg').html('');
                    $('#modalItemEditorSubItems').val('[]');
                    $('[name="featured_label"]').val([1])

                    $("#subItemsWrapper").hide();
                    $("#modalItemEditorEffectsRow").show();

                    $('#modalItemEditor').modal('show');
                    break;
                case 2:
                    $('#modalItemEditorTitle').html('Edit Item');
                    $('#modalItemEditorAction').html('Apply Changes');
                    $('#modalItemEditorName').val(item.data('name'));
                    $('#modalItemEditorDesc').html(item.data('description'));
                    $('#modalItemEditorEffects').tagsinput('removeAll');
                    $.each(item.data('effects'), function(i, obj) {
                        $('#modalItemEditorEffects').tagsinput('add', obj);
                    });
                    $('#modalItemEditorId').val(item.data('itemid'));
                    $('#modalItemEditorQty').val(item.data('quantity'));
                    $('#modalItemEditorCategory').val(item.data('category'));
                    $('#modalItemEditorPrice').val(item.data('price'));
                    $('#modalItemEditorImg').html(basename(item.data('image')));
                    $('#modalItemEditorSubItems').val(JSON.stringify(item.data('subitems')));
                    $('[name="featured_label"]').val([item.data('label')])

                    if (item.data('category') == 4) {
                        $("#subItemsWrapper").show();
                        $("#modalItemEditorEffectsRow").hide();

                        var subitems = item.data('subitems');
                        if (subitems.length > 0) {
                            var index = 0;
                            for (const entry in subitems) {
                                if (index == 0) {
                                    $("input[name='sub_item_name[]']:eq(0)").val(subitems[entry].Name);
                                    $("input[name='sub_item_name[]']:eq(0)").data("id", subitems[entry].id);
                                    $("#subItems .input-group:eq(0) .custom-file-label").html(basename(subitems[entry].Image));
                                    $("#subItems .input-group:eq(0) input").data("id", subitems[entry].id);
                                } else {
                                    $("#subItems").append('<div class="input-group mt-2"> <input data-id="'+ subitems[entry].id + '" onchange="subItemsOnChange(this)" type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off" value="'+ subitems[entry].Name +'"> <div class="input-group-append"> <button type="button" class="btn btn-danger removeSubItem">-</button> </div> <div class="custom-file" style="margin-left: 7px; padding-left: 60px;"> <input data-id="'+ subitems[entry].id + '" onchange="subItemsOnChange(this)"  type="file" class="custom-file-input" name="sub_item_img[]"> <label class="custom-file-label">'+ basename(subitems[entry].Image) +'</label> </div> </div>');
                                }
                                index++;
                            }
                        }
                    } else {
                        $("#subItemsWrapper").hide();
                        $("#modalItemEditorEffectsRow").show();
                    }

                    $('#modalItemEditor').modal('show');
                    break;
            }
        }

        function subItemsOnChange(el) {
            var item = jQuery(el);
            var subitems = JSON.parse($('#modalItemEditorSubItems').val());

            //console.log(item.attr('type'));
            for (var entry in subitems) {
                if (subitems[entry].Name == el.value) {
                    alert('Cannot use existing name!');
                    el.value = '';
                    item.focus();
                    break;
                }

                if (item.attr('type') == 'file' && item.data('id') == null &&
                    item.parent().parent().find('input:eq(0)').val() == subitems[entry].Name) {
                    subitems[entry].NewFile = true;
                    break;
                }
                //console.log(item.data('id') + ' with ' + subitems[entry].id);
                if ((item.data('id') == null && el.oldvalue == subitems[entry].Name) || (item.data('id') != null && item.data('id') == subitems[entry].id)) {
                    //console.log(el.oldvalue + '|' + subitems[entry].Name + ' -> ' + el.value);
                    if (item.attr('type') == 'file') {
                        subitems[entry].NewFile = true;
                    } else {
                        subitems[entry].Name = el.value;
                    }

                    break;
                }
            }

            $('#modalItemEditorSubItems').val(JSON.stringify(subitems));
        }

        function showRedeemEditor(el, mode) {
            var item = jQuery(el);
            $('#modalRedeemEditorMode').val(mode);
            $('#modalRedeemEditorErrorWrapper').hide();
            $("#modalRedeemEditorCode").prop('disabled', false);
            switch(mode) {
                case 0:
                    break;
                case 1:
                    $('#modalRedeemEditorTitle').html('Add Code');
                    $('#modalRedeemEditorBtn').html('Submit');
                    $('#modalRedeemEditorOldCode').val('');
                    $('#modalRedeemEditorCode').val('');
                    $('#modalRedeemEditorItemID').val('');
                    $('#modalRedeemEditorQuantity').val(1);
                    $('#modalRedeemEditor').modal('show');
                    break;
                case 2:
                    $('#modalRedeemEditorTitle').html('Edit Code');
                    $('#modalRedeemEditorBtn').html('Save Changes');
                    $('#modalRedeemEditorOldCode').val(item.data('code'));
                    $('#modalRedeemEditorCode').val(item.data('code'));
                    $('#modalRedeemEditorItemID').val(item.data('itemid'));
                    $('#modalRedeemEditorQuantity').val(item.data('quantity'));
                    $('#modalRedeemEditor').modal('show');
                    break;
            }
        }

        function showPartnerEditor(el, mode) {
            var item = jQuery(el);
            $('#modalPartnerEditorMode').val(mode);
            $('#modalPartnerEditorErrorWrapper').hide();
            switch(mode) {
                case 0:
                    break;
                case 1:
                    $('#modalPartnerEditorTitle').html('Add Partner');
                    $('#modalPartnerEditorBtn').html('Submit');
                    $('#modalPartnerEditorId').val('');
                    $("#modalPartnerEditorName").prop('disabled', false);
                    $('#modalPartnerEditorName').val('');
                    $('#modalPartnerEditorCode').val('');
                    $('#modalPartnerEditorMoney').val(0);
                    $('#modalPartnerEditor').modal('show');
                    break;
                case 2:
                    $('#modalPartnerEditorTitle').html('Edit Partner');
                    $('#modalPartnerEditorBtn').html('Save Changes');
                    $('#modalPartnerEditorId').val(item.data('userid'));
                    $("#modalPartnerEditorName").prop('disabled', true);
                    $('#modalPartnerEditorName').val(item.data('name'));
                    $('#modalPartnerEditorCode').val(item.data('code'));
                    $('#modalPartnerEditorMoney').val(item.data('money'));
                    $('#modalPartnerEditor').modal('show');
                    break;
            }
        }

        function showTierEditor(el, mode) {
            var item = jQuery(el);
            $('#modalTierEditorMode').val(mode);
            $('#modalTierEditorErrorWrapper').hide();
            resetRewardsItems();
            switch(mode) {
                case 0:
                    break;
                case 1:
                    $('#modalTierEditorTitle').html('Add Tier');
                    $('#modalTierEditorBtn').html('Submit');
                    $('#modalTierEditorId').val('');
                    $("#modalTierEditorName").prop('disabled', false);
                    $('#modalTierEditorName').val('');
                    $('#modalTierEditorCode').val('');
                    $('#modalTierEditorMoney').val(0);
                    $('#modalTierEditor').modal('show');
                    break;
                case 2:
                    $('#modalTierEditorTitle').html('Edit Tier');
                    $('#modalTierEditorBtn').html('Save Changes');
                    $('#modalTierEditorId').val(item.data('id'));
                    $('#modalTierEditorMoney').val(item.data('goal'));

                    var subitems = item.data('rewards');
                    if (subitems.length > 0) {
                        var index = 0;
                        for (const entry in subitems) {
                            if (index == 0) {
                                console.log();
                                $('.rewardItem:eq(0)').children('.input-group:eq(0)').children('input:eq(0)').val(subitems[entry].name);
                                $('.rewardItem:eq(0)').children('.input-group:eq(0)').children('input:eq(1)').val(subitems[entry].itemId);
                                $('.rewardItem:eq(0)').children('.input-group:eq(0)').children('input:eq(2)').val(subitems[entry].id);
                                $('.rewardItem:eq(0)').children('.input-group:eq(1)').children('input:eq(0)').val(subitems[entry].quantity);
                                $('.rewardItem:eq(0)').children('.input-group:eq(2)').children('.custom-file').children('.custom-file-label').html(subitems[entry].image_link);
                            } else {
                                $("#rewards").append('<div class="rewardItem"><hr class="hr-text" data-content="Reward #' + (index + 1) + '"> <div class="input-group mb-2"> <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-default">Item Name</span> </div> <input type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off" value="'+subitems[entry].name+'"> <div class="input-group-prepend ml-2"> <span class="input-group-text" id="inputGroup-sizing-default">Item ID</span> </div> <input type="text" name="sub_item_id[]" class="form-control m-input" placeholder="Item ID" autocomplete="off" value="'+subitems[entry].itemId+'"><input type="hidden" name="sub_item_reward_id[]" value="'+subitems[entry].id+'"> </div> <div class="input-group mb-2"> <input data-prefix="Quantity" type="number" name="sub_item_quantity[]" class="form-control m-input h-auto" autocomplete="off" value="'+subitems[entry].quantity+'" min="0" step="1"> </div> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-default">Image File</span> </div> <div class="custom-file" style="padding-left: 60px;"> <input type="file" class="custom-file-input" name="sub_item_img[]" placeholder="Image File"> <label class="custom-file-label">'+subitems[entry].image_link+'</label> </div> <div class="input-group-append"> <button type="button" class="btn btn-danger removeSubItem">-</button> </div></div></div>');
                                //$("#subItems").append('<div class="input-group mt-2"> <input data-id="'+ subitems[entry].id + '" onchange="subItemsOnChange(this)" type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off" value="'+ subitems[entry].Name +'"> <div class="input-group-append"> <button type="button" class="btn btn-danger removeSubItem">-</button> </div> <div class="custom-file" style="margin-left: 7px; padding-left: 60px;"> <input data-id="'+ subitems[entry].id + '" onchange="subItemsOnChange(this)"  type="file" class="custom-file-input" name="sub_item_img[]"> <label class="custom-file-label">'+ basename(subitems[entry].Image) +'</label> </div> </div>');
                            }
                            index++;
                        }
                        $("input[type='number']").inputSpinner();
                    }

                    $('#modalTierEditor').modal('show');
                    break;
            }
        }

        function submitRedeemEditor(el) {
            var item = jQuery(el);
            $('#modalRedeemEditorErrorWrapper').fadeOut();
            item.prop('disabled', true);

            $.ajax({
                url: "{{ route('admin',[],false) }}",
                method: "POST",
                dataType: 'json',
                data: new FormData($("#modalRedeemEditorForm")[0]),
                processData: false,
                contentType: false,
                success: function(data){
                    if (data.message === 'success') {
                        location.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    item.prop('disabled', false);
                    $('#modalRedeemEditorErrorMsg').html(xhr.responseJSON.message);
                    $('#modalRedeemEditorErrorList').html('');
                    if (xhr.responseJSON.hasOwnProperty('errors')) {
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            var listItem = $("<li/>");
                            listItem.html(data[0]);
                            listItem.appendTo("#modalRedeemEditorErrorList");
                        })
                    }

                    $('#modalRedeemEditorErrorWrapper').fadeIn();
                }
            });
        }

        function submitPartnerEditor(el) {
            var item = jQuery(el);
            $('#modalPartnerEditorErrorWrapper').fadeOut();
            item.prop('disabled', true);

            $.ajax({
                url: "{{ route('admin',[],false) }}",
                method: "POST",
                dataType: 'json',
                data: new FormData($("#modalPartnerEditorForm")[0]),
                processData: false,
                contentType: false,
                success: function(data){
                    if (data.message === 'success') {
                        location.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    item.prop('disabled', false);
                    $('#modalPartnerEditorErrorMsg').html(xhr.responseJSON.message);
                    $('#modalPartnerEditorErrorList').html('');
                    if (xhr.responseJSON.hasOwnProperty('errors')) {
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            var listItem = $("<li/>");
                            listItem.html(data[0]);
                            listItem.appendTo("#modalPartnerEditorErrorList");
                        })
                    }

                    $('#modalPartnerEditorErrorWrapper').fadeIn();
                }
            });
        }

        function submitTierEditor(el) {
            let rewardsJson = [];
            $('.rewardItem').each(function(i, obj) {
                let itemName = $(this).children('.input-group:eq(0)').children('input:eq(0)').val();
                let itemId = $(this).children('.input-group:eq(0)').children('input:eq(1)').val();
                let rewardId = $(this).children('.input-group:eq(0)').children('input:eq(2)').val();
                let quantity = $(this).children('.input-group:eq(1)').children('input:eq(0)').val();
                let fileName = $(this).children('.input-group:eq(2)').children('.custom-file').children('input').val();

                rewardsJson.push({
                    "tierId": $('#modalTierEditorId').val(),
                    "rewardId": rewardId,
                    "itemName": itemName,
                    "itemId": itemId,
                    "quantity": quantity,
                    "fileName": fileName,
                });
            });

            $('#modalTierEditorRewardItems').val(JSON.stringify(rewardsJson));

            var item = jQuery(el);
            $('#modalTierEditorErrorWrapper').fadeOut();
            item.prop('disabled', true);

            $.ajax({
                url: "{{ route('admin',[],false) }}",
                method: "POST",
                dataType: 'json',
                data: new FormData($("#modalTierEditorForm")[0]),
                processData: false,
                contentType: false,
                success: function(data){
                    if (data.message === 'success') {
                        location.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    item.prop('disabled', false);
                    $('#modalTierEditorErrorMsg').html(xhr.responseJSON.message);
                    $('#modalTierEditorErrorList').html('');
                    if (xhr.responseJSON.hasOwnProperty('errors')) {
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            var listItem = $("<li/>");
                            listItem.html(data[0]);
                            listItem.appendTo("#modalTierEditorErrorList");
                        })
                    }

                    $('#modalTierEditorErrorWrapper').fadeIn();
                }
            });
        }

        function submitItemEditor(el) {
            var item = jQuery(el);
            $('#modalItemEditorErrorWrapper').fadeOut();
            item.prop('disabled', true);
            var effects = $('<input/>')
            if($('#_effects').length) {
                effects = $('#_effects');
            }
            effects.attr('type', 'hidden');
            effects.attr('name', 'effects');
            effects.attr('id', '_effects');
            effects.val(JSON.stringify($('#modalItemEditorEffects').tagsinput('items')));
            $('#modalItemEditorForm').append(effects);

            $.ajax({
                url: "{{ route('admin',[],false) }}",
                method: "POST",
                dataType: 'json',
                data: new FormData($("#modalItemEditorForm")[0]),
                processData: false,
                contentType: false,
                success: function(data){
                    if (data.message === 'success') {
                        location.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    item.prop('disabled', false);
                    $('#modalItemEditorErrorMsg').html(xhr.responseJSON.message);
                    $('#modalItemEditorErrorList').html('');
                    if (xhr.responseJSON.hasOwnProperty('errors')) {
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            var listItem = $("<li/>");
                            listItem.html(data[0]);
                            listItem.appendTo("#modalItemEditorErrorList");
                        })
                    }

                    $('#modalItemEditorErrorWrapper').fadeIn();
                }
            });
        }

        function submitPlayerEditor(el) {
            var item = jQuery(el);
            item.prop('disabled', true);
            $('#modalPlayerEditorErrorWrapper').fadeOut();
            $('#modalPlayerEditorMode').val(2);
            $.ajax({
                url: "{{ route('admin',[],false) }}",
                method: "POST",
                dataType: 'json',
                data: new FormData($("#modalPlayerEditorForm")[0]),
                processData: false,
                contentType: false,
                success: function(data){
                    if (data.message === 'success') {
                        location.reload();
                    }
                },
                error: function(xhr, textStatus, errorThrown){
                    item.prop('disabled', false);
                    $('#modalPlayerEditorErrorMsg').html(xhr.responseJSON.message);
                    $('#modalPlayerEditorErrorList').html('');
                    if (xhr.responseJSON.hasOwnProperty('errors')) {
                        $.each(xhr.responseJSON.errors, function (key, data) {
                            var listItem = $("<li/>");
                            listItem.html(data[0]);
                            listItem.appendTo("#modalPlayerEditorErrorList");
                        })
                    }

                    $('#modalPlayerEditorErrorWrapper').fadeIn();
                }
            });
        }

        function showPlayerEditor(el) {
            var item = jQuery(el);
            item.prop('disabled', true);
            $('#modalPlayerEditorErrorWrapper').hide();

            $.post( "{{ route('admin',[],false) }}", $( "#playerForm" ).serialize())
                .done(function(data) {
                    item.prop('disabled', false);
                    if (data.player === null) {
                        $('#modal').modal('show');
                        $('#modal .modal-title').html('Search failure');
                        $('#modal .modal-body').html('Unable to find the specified user.');
                        return;
                    } else {

                        $('#modalPlayerEditorId').val(data.player.id_idx);
                        $('#modalPlayerEditorName').val(data.player.id_loginid);
                        $('#modalPlayerEditorCategory').val(data.player.UserLevel);
                        $('#modalPlayerEditorCash').val(data.player.UserPointMall);
                        $('#modalPlayerEditor').modal('show');
                    }
                })
                .fail( function(xhr, textStatus, errorThrown) {
                    item.prop('disabled', false);
                });
        }

        function resetRewardsItems() {
            $("#rewards").html('<div class="rewardItem"> <hr class="hr-text" data-content="Reward #1"> <div class="input-group mb-2"> <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-default">Item Name</span> </div> <input type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off"> <div class="input-group-prepend ml-2"> <span class="input-group-text" id="inputGroup-sizing-default">Item ID</span> </div> <input type="text" name="sub_item_id[]" class="form-control m-input" placeholder="Item ID" autocomplete="off"> <input type="hidden" name="sub_item_reward_id[]"> </div> <div class="input-group mb-2"> <input data-prefix="Quantity" type="number" name="sub_item_quantity[]" class="form-control m-input h-auto" autocomplete="off" value="1" min="0" step="1"> </div> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-default">Image File</span> </div> <div class="custom-file" style="padding-left: 60px;"> <input type="file" class="custom-file-input" name="sub_item_img[]" placeholder="Image File"> <label class="custom-file-label">No file chosen</label> </div> <div class="input-group-append"> <button id="addRewardItem" type="button" class="btn btn-success">+</button> </div> </div> </div>');
        }

        function resetSubItems() {
            $("#subItems").html('<div class="input-group"> <input onchange="subItemsOnChange(this)" type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off"> <div class="input-group-append"> <button id="addSubItem" type="button" class="btn btn-success">+</button> </div> <div class="custom-file" style="margin-left: 7px; padding-left: 60px;"> <input onchange="subItemsOnChange(this)" type="file" class="custom-file-input" name="sub_item_img[]"> <label class="custom-file-label"></label> </div> </div>');
        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="modalShowActDetails" tabindex="-1" role="dialog" aria-labelledby="ActivityDetails" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShowActTitle">Activity Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <pre id="json-renderer"></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRedeemEditor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="modalRedeemEditorForm">
                    @csrf
                    <input type="hidden" name="mode" value="redeemeditor">
                    <input type="hidden" name="old_code" value="" id="modalRedeemEditorOldCode">
                    <input type="hidden" name="action" value="" id="modalRedeemEditorMode">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRedeemEditorTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalRedeemEditorErrorWrapper">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong id="modalRedeemEditorErrorMsg">{{ __('Whoops! Something went wrong.') }}</strong>
                                <div id="modalRedeemEditorErrorList"></div>
                                <button type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="modalRedeemEditorCode" placeholder="Redeem Code" name="code" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Item ID</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="modalRedeemEditorItemID" placeholder="Enter the item ID here.." name="itemid">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Quantity</label>
                            <div class="col-sm-8">
                                <input name="quantity" id="modalRedeemEditorQuantity" class="form-control h-auto" type="number" value="1" min="1" max="100" step="1"/>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitRedeemEditor(this);" id="modalRedeemEditorBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalPartnerEditor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="modalPartnerEditorForm">
                    @csrf
                    <input type="hidden" name="mode" value="partnereditor">
                    <input type="hidden" name="action" value="" id="modalPartnerEditorMode">
                    <input type="hidden" name="userid" value="" id="modalPartnerEditorId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPartnerEditorTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalPartnerEditorErrorWrapper">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong id="modalPartnerEditorErrorMsg">{{ __('Whoops! Something went wrong.') }}</strong>
                                <div id="modalPartnerEditorErrorList"></div>
                                <button type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="modalPartnerEditorName" placeholder="Partner Name" name="name" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Referral Code</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="modalPartnerEditorCode" placeholder="Enter the referral code here.." name="code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Virtual Money</label>
                            <div class="col-sm-8">
                                <input name="virtual_money" id="modalPartnerEditorMoney" class="form-control h-auto" type="number" value="0" min="0" step="100"/>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitPartnerEditor(this);" id="modalPartnerEditorBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTierEditor" tabindex="-1" role="dialog" aria-hidden="true" style="min-width:90%">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form id="modalTierEditorForm">
                    @csrf
                    <input type="hidden" name="mode" value="tiereditor">
                    <input type="hidden" name="action" value="" id="modalTierEditorMode">
                    <input type="hidden" name="tierid" value="" id="modalTierEditorId">
                    <input type="hidden" name="rewarditems" value="[]" id="modalTierEditorRewardItems">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTierEditorTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalTierEditorErrorWrapper">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong id="modalTierEditorErrorMsg">{{ __('Whoops! Something went wrong.') }}</strong>
                                <div id="modalTierEditorErrorList"></div>
                                <button type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Goal Money</label>
                            <div class="col-sm-10">
                                <input name="goal" id="modalTierEditorMoney" class="form-control h-auto" type="number" value="0" min="0" step="100000"/>
                            </div>
                        </div>

                        <div class="form-group row" id="rewardsWrapper">
                            <label class="col-sm-2 col-form-label">Rewards</label>
                            <div class="col-sm-10" id="rewards">
                                <div class="rewardItem">
                                    <hr class="hr-text" data-content="Reward #1">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Item Name</span>
                                        </div>
                                        <input type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off">

                                        <div class="input-group-prepend ml-2">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Item ID</span>
                                        </div>
                                        <input type="text" name="sub_item_id[]" class="form-control m-input" placeholder="Item ID" autocomplete="off">
                                        <input type="hidden" name="sub_item_reward_id[]">
                                    </div>

                                    <div class="input-group mb-2">
                                        <input data-prefix="Quantity" type="number" name="sub_item_quantity[]" class="form-control m-input h-auto" autocomplete="off" value="1" min="0" step="1">
                                    </div>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Image File</span>
                                        </div>
                                        <div class="custom-file" style="padding-left: 60px;">
                                            <input type="file" class="custom-file-input" name="sub_item_img[]" placeholder="Image File">
                                            <label class="custom-file-label">No file chosen</label>
                                        </div>

                                        <div class="input-group-append">
                                            <button id="addRewardItem" type="button" class="btn btn-success">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitTierEditor(this);" id="modalTierEditorBtn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalPlayerEditor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="modalPlayerEditorForm">
                    @csrf
                    <input type="hidden" name="mode" value="playereditor">
                    <input type="hidden" name="action" value="" id="modalPlayerEditorMode">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPlayerEditorTitle">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalPlayerEditorErrorWrapper">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong id="modalPlayerEditorErrorMsg">{{ __('Whoops! Something went wrong.') }}</strong>
                                <div id="modalPlayerEditorErrorList"></div>
                                <button type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="modalPlayerEditorId" placeholder="Identifier" name="userid">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="modalPlayerEditorName" placeholder="Item Name" name="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Access Level</label>
                            <div class="col-sm-9">
                                <select id="modalPlayerEditorCategory" class="custom-select" name="accesslevel">
                                    <option value="1">God</option>
                                    <option value="2">Developer</option>
                                    <option value="3">Programmer</option>
                                    <option value="4">Game Master</option>
                                    <option value="5">Moderator</option>
                                    <option value="6">Player</option>
                                    <option value="7">Banned</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Cash Points</label>
                            <div class="col-sm-9">
                                <input name="cashpoints" id="modalPlayerEditorCash" class="form-control h-auto" type="number" value="0" min="0" step="500"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitPlayerEditor(this);">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalItemEditor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="modalItemEditorForm">
                    @csrf
                    <input type="hidden" name="mode" value="malleditor">
                    <input type="hidden" name="action" value="" id="modalItemEditorMode">
                    <input type="hidden" name="subitems" value="" id="modalItemEditorSubItems">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalItemEditorTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalItemEditorErrorWrapper">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong id="modalItemEditorErrorMsg">{{ __('Whoops! Something went wrong.') }}</strong>
                                <div id="modalItemEditorErrorList"></div>
                                <button type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Item ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="modalItemEditorId" placeholder="Identifier" name="itemid">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="modalItemEditorName" placeholder="Item Name" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea id="modalItemEditorDesc" class="form-control" placeholder="Enter long description here.." name="description"></textarea>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select id="modalItemEditorCategory" class="custom-select" name="category">
                                    <option value="0" name="modalItemEditorCategoryDefault" selected>Choose option</option>
                                    <option value="1">Equipment</option>
                                    <option value="2">Costume</option>
                                    <option value="3">Accessories</option>
                                    <option value="4">Consumables</option>
                                    <option value="5">Back Gear</option>
                                    <option value="6">Style</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="modalItemEditorEffectsRow">
                            <label class="col-sm-3 col-form-label">Effects</label>
                            <div class="col-sm-9">

                                <select multiple data-role="tagsinput" id="modalItemEditorEffects">

                                </select>

                                <small class="form-text text-muted pl-1">Press enter for each effect you want to apply.</small>
                            </div>
                        </div>

                        <div class="form-group row" id="subItemsWrapper">
                            <label class="col-sm-3 col-form-label">Sub Items</label>
                            <div class="col-sm-9" id="subItems">
                                <div class="input-group">
                                    <input type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="addSubItem" type="button" class="btn btn-success">+</button>
                                    </div>

                                    <div class="custom-file" style="margin-left: 7px; padding-left: 60px;">
                                        <input type="file" class="custom-file-input" name="sub_item_img[]">
                                        <label class="custom-file-label"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Quantity</label>
                            <div class="col-sm-9">
                                <input name="quantity" id="modalItemEditorQty" class="form-control h-auto" type="number" value="0" min="1" step="1"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input name="price" id="modalItemEditorPrice" class="form-control h-auto" type="number" value="0" min="0" step="100"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img">
                                    <label class="custom-file-label" id="modalItemEditorImg"></label>
                                    <small class="form-text text-muted pl-1">Max. dimension is 200px width and 260px height.</small>
                                </div>
                            </div>
                        </div>

                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-3 pt-0">Label</legend>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="featured_label" id="modalItemEditorLabel1" value="1" checked>
                                        <label class="form-check-label badge badge-success " for="gridRadios1">
                                            New
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="featured_label" id="modalItemEditorLabel2" value="2">
                                        <label class="form-check-label badge badge-warning " for="gridRadios2">
                                            Hot
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="featured_label" id="modalItemEditorLabel3" id="gridRadios3" value="0">
                                        <label class="form-check-label badge badge-secondary " for="gridRadios3" style="color: #fff;">
                                            None
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitItemEditor(this);" id="modalItemEditorAction">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>&nbsp;
                        <strong>This action cannot be undone.</strong> Proceed with caution.
                    </div>
                    <p id="modalText" class="text-center">Are you sure you want to approve the following transaction?</p>
                    <div class="card mt-2 w-100">
                        <ul class="list-group list-group-flush" id="modalList">
                            <li class="list-group-item">Username
                                <span class="float-right"><strong id="modalUsername"></strong></span>
                            </li>
                            <li class="list-group-item">Reference ID
                                <span class="float-right"><strong id="modalRef"></strong></span>
                            </li>
                            <li class="list-group-item">Payment Method
                                <span class="float-right"><strong id="modalMethod"></strong></span>
                            </li>
                            <li class="list-group-item">Total Due
                                <span class="float-right"><strong id="modalDue"></strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <form id="modalConfirmationForm" method="POST" action="{{ route('admin') }}">
                        @csrf
                        <input type="hidden" name="mode" value="" id="modalMode">
                        <input type="hidden" name="action" value="" id="modalAction">
                        <input type="hidden" name="id" value="" id="modalId">
                        <input type="hidden" name="itemid" value="" id="modalItemId">
                        <input type="hidden" name="quantity" value="" id="modalItemQty">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="modalBtn" type="submit">Approve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row tile p-4 mx-0 my-4">

        <div class="col-12">
            <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
            <x-auth-session-status class="alert alert-success" :status="session('status')" />
            <div class="subtitle">Admin Panel</div>
            <div class="article pb-3" style="text-indent: 0;">You are viewing a sensitive page as <strong>administrative discretion</strong> is required.</div>
        </div>

        <div class="col-3">
            <nav>
                <div class="nav flex-column nav-pills" id="nav-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link @if (Session::get('tab') === null) active @endif" id="nav-settings-tab" data-toggle="pill" href="#nav-activity" role="tab" aria-controls="nav-activity" aria-selected="false">Activity Log</a>
                    <a class="nav-link @if (Session::get('tab') === 'settings') active @endif" id="nav-settings-tab" data-toggle="pill" href="#nav-settings" role="tab" aria-controls="nav-settings" aria-selected="false">Web Settings</a>
                    <a class="nav-link @if (Session::get('tab') == 'itemmall') active @endif" id="nav-im-tab" data-toggle="pill" href="#nav-im" role="tab" aria-controls="nav-im" aria-selected="false">Item Mall</a>
                    <a class="nav-link @if (Session::get('tab') == 'transactions') active @endif" id="nav-topup-tab" data-toggle="pill" href="#nav-topup" role="tab" aria-controls="nav-topup" aria-selected="false">Top Up Approvals @if($transactions->count() > 0) ({{ $transactions->count() }}) @endif</a>
                    <a class="nav-link @if (Session::get('tab') == 'referrals') active @endif" id="nav-referrals-tab" data-toggle="pill" href="#nav-referrals" role="tab" aria-controls="nav-referrals" aria-selected="false">Referrals</a>
                    <a class="nav-link @if (Session::get('tab') == 'player') active @endif" id="nav-player-tab" data-toggle="pill" href="#nav-player" role="tab" aria-controls="nav-player" aria-selected="false">Manage User</a>
                    <a class="nav-link @if (Session::get('tab') == 'items') active @endif" id="nav-items-tab" data-toggle="pill" href="#nav-items" role="tab" aria-controls="nav-items" aria-selected="false">Item Delivery</a>
                    <a class="nav-link @if (Session::get('tab') == 'report') active @endif" id="nav-report-tab" data-toggle="pill" href="#nav-report" role="tab" aria-controls="nav-report" aria-selected="false">Transaction Report</a>
                    <a class="nav-link @if (Session::get('tab') == 'redeem') active @endif" id="nav-redeem-tab" data-toggle="pill" href="#nav-redeem" role="tab" aria-controls="nav-redeem" aria-selected="false">Redeem</a>
                    <a class="nav-link @if (Session::get('tab') == 'ranking') active @endif" id="nav-ranking-tab" data-toggle="pill" href="#nav-ranking" role="tab" aria-controls="nav-ranking" aria-selected="false">Top Up Ranking</a>
                    <a class="nav-link @if (Session::get('tab') == 'tiered') active @endif" id="nav-tiered-tab" data-toggle="pill" href="#nav-tiered" role="tab" aria-controls="nav-tiered" aria-selected="false">Tiered Spender</a>
                </div>
            </nav>
        </div>

        <div class="col-9">


            <div class="tab-content " id="nav-tabContent">
                <div class="tab-pane fade @if (Session::get('tab') === null) active show @endif" id="nav-activity" role="tabpanel" aria-labelledby="nav-activity-tab">
                    <div class="form-group">

                        @if(!Helper::isOwner())
                            <div class="subtitle" style="font-size: 1.2rem;">Not Authorized</div>
                            <div class="article pb-2" style="text-indent: 0;">You don't have permission to access this page.</div>
                        @else
                            <div class="subtitle" style="font-size: 1.2rem;">Activity Log</div>
                            <div class="article pb-3" style="text-indent: 0;">List of admin activities.</div>
                            <div class="table-responsive">
                                <table class="table pt-1">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col" class="text-center">Date</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activities as $data)
                                        <tr>
                                            <td class="align-middle text-center">{{ App\Models\User::find($data->causer_id)->id_loginid }}</td>
                                            <td class="align-middle">{{ $data->description }}</td>
                                            @switch($data->subject_type)
                                                @case('App\Models\WebSettings')
                                                <td class="align-middle"><b>Web Settings</b></td>
                                                @break
                                                @case('App\Models\ItemMall')
                                                <td class="align-middle"><b>Item Name:</b> {!! $data->subject_type::find($data->subject_id) !== null ? $data->subject_type::find($data->subject_id)->name : "<i>Deleted</i>" !!}</td>
                                                @break
                                                @case('App\Models\Invoice')
                                                <td class="align-middle"><b>Transction ID:</b> {{ $data->subject_id }}</td>
                                                @break
                                                @case('App\Models\User')
                                                <td class="align-middle"><b>Username:</b> {!! $data->subject_type::find($data->subject_id) !== null ?  $data->subject_type::find($data->subject_id)->id_loginid : "<i>Deleted</i>" !!}</td>
                                                @break
                                                @case('App\Models\Partner')
                                                <td class="align-middle"><b>Ref Code:</b> {{ $data->subject_id }}</td>
                                                @break
                                                @case('App\Models\Item')
                                                <td class="align-middle"><b>Item ID:</b> {{ $data->subject_id }}</td>
                                                @break
                                                @case('App\Models\Redeem')
                                                <td class="align-middle"><b>Code:</b> {{ $data->subject_id }}</td>
                                                @break
                                                @case('App\Models\Tier')
                                                <td class="align-middle"><b>Tier ID:</b> {{ $data->subject_id }}</td>
                                                @break
                                                @default
                                                @if($data->event == 'download')
                                                    <td class="align-middle"><b>Transaction Report</b></td>
                                                @else
                                                    <td class="align-middle"></td>
                                                @endif
                                            @endswitch

                                            <td class="align-middle">{{ $data->created_at }}</td>
                                            <td class="d-flex justify-content-center align-middle">
                                                <button type="button" class="btn btn-secondary mr-1" style="padding: .375rem .75rem;"
                                                        data-raw="{!! htmlspecialchars(json_encode($data->properties), ENT_QUOTES, 'UTF-8') !!}"
                                                        onclick="showActivityDetails(this, this.dataset.raw)">

                                                    <i class="fas fa-search"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center w-100">
                                {!! $activities->links() !!}
                            </div>
                        @endif

                    </div>
                </div>

                <div class="tab-pane fade  @if (Session::get('tab') === 'settings') active show @endif" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
                    <form method="POST" class="m-auto  w-100" action="{{ route('admin') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="mode" value="web">
                        <div class="subtitle" style="font-size: 1.2rem;">Game Patch</div>
                        <div class="article pb-3" style="text-indent: 0;">Updates game patch links on the <a href="{{ route('download') }}">download</a> page.</div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Game Version</label>
                            <div class="col-sm-10">
                                <input type="text" name="patch_version" class="form-control" value="{{ Helper::getSetting('patch_version') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Date Updated</label>
                            <div class="col-sm-10">
                                <input type="text" name="patch_date" class="form-control" value="{{ Helper::getSetting('patch_date') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Google Drive Link</label>
                            <div class="col-sm-10">
                                <input type="text" name="patch_dl_gdrive" class="form-control" value="{{ Helper::getSetting('patch_dl_gdrive') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Mediafire Link</label>
                            <div class="col-sm-10">
                                <input type="text" name="patch_dl_mfire" class="form-control" value="{{ Helper::getSetting('patch_dl_mfire') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Mega Link</label>
                            <div class="col-sm-10">
                                <input type="text" name="patch_dl_mega" class="form-control" value="{{ Helper::getSetting('patch_dl_mega') }}">
                            </div>
                        </div>

                        <hr class="mt-4" />
                        <div class="subtitle" style="font-size: 1.2rem;">Server Info</div>
                        <div class="article pb-3" style="text-indent: 0;">Adjust server informations that are displayed in <a href="{{ route('features') }}">features</a> page.</div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Location</label>
                            <div class="col-sm-10">
                                <input type="text" name="server_location" class="form-control" value="{{ Helper::getSetting('server_location') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Timezone</label>
                            <div class="col-sm-10">
                                <input type="text" name="server_timezone" class="form-control" value="{{ Helper::getSetting('server_timezone') }}">
                            </div>
                        </div>

                        <hr class="mt-4" />
                        <div class="subtitle" style="font-size: 1.2rem;">Rates</div>
                        <div class="article pb-3" style="text-indent: 0;">Adjust rates that are displayed in <a href="{{ route('features') }}">Features</a> page. It does not affect actual in-game rates.</div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">EXP Rate</label>
                            <div class="col-sm-10">
                                <input type="text" name="rate_exp" class="form-control" value="{{ Helper::getSetting('rate_exp') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Gold Rate</label>
                            <div class="col-sm-10">
                                <input type="text" name="rate_gold" class="form-control" value="{{ Helper::getSetting('rate_gold') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Drop Rate</label>
                            <div class="col-sm-10">
                                <input type="text" name="rate_drop" class="form-control" value="{{ Helper::getSetting('rate_drop') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Party Rate</label>
                            <div class="col-sm-10">
                                <input type="text" name="rate_party" class="form-control" value="{{ Helper::getSetting('rate_party') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Level Cap</label>
                            <div class="col-sm-10">
                                <input type="text" name="cap_level" class="form-control" value="{{ Helper::getSetting('cap_level')}}">
                            </div>
                        </div>

                        <hr class="mt-4" />
                        <div class="subtitle" style="font-size: 1.2rem;">Images</div>
                        <div class="article pb-3" style="text-indent: 0;">Changes the web display images template.</div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Banner</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_banner">
                                    <label class="custom-file-label">{{ basename(Helper::getSetting('img_banner')) }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_logo">
                                    <label class="custom-file-label">{{ basename(Helper::getSetting('img_logo')) }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Hero</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_hero">
                                    <label class="custom-file-label">{{ basename(Helper::getSetting('img_hero')) }}</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Login Banner</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_login">
                                    <label class="custom-file-label">{{ basename(Helper::getSetting('img_login')) }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Slider Banner 1</label>
                            <div class="col-sm-5">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_banner_1">
                                    <label class="custom-file-label">{{ basename(Helper::getSetting('img_banner_1')) }}</label>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <input type="text" name="img_banner_1_link" class="form-control" placeholder="Banner URL" value="{{ Helper::getSetting('img_banner_1_link') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Slider Banner 2</label>
                            <div class="col-sm-5">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_banner_2">
                                    <label class="custom-file-label">{{ basename(Helper::getSetting('img_banner_2')) }}</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="img_banner_2_link" class="form-control" placeholder="Banner URL" value="{{ Helper::getSetting('img_banner_2_link') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Slider Banner 3</label>
                            <div class="col-sm-5">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_banner_3">
                                    <label class="custom-file-label">{{ basename(Helper::getSetting('img_banner_3')) }}</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="img_banner_3_link" class="form-control" placeholder="Banner URL" value="{{ Helper::getSetting('img_banner_3_link') }}">
                            </div>
                        </div>

                        <hr class="mt-4" />
                        <div class="subtitle" style="font-size: 1.2rem;">Social Medias</div>
                        <div class="article pb-3" style="text-indent: 0;">Updates social media hyperlinks.</div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Facebook</label>
                            <div class="col-sm-10">
                                <input type="text" name="social_facebook" class="form-control" value="{{ Helper::getSetting('social_facebook') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Discord</label>
                            <div class="col-sm-10">
                                <input type="text" name="social_discord" class="form-control" value="{{ Helper::getSetting('social_discord') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Instagram</label>
                            <div class="col-sm-10">
                                <input type="text" name="social_instagram" class="form-control" value="{{ Helper::getSetting('social_instagram') }}">
                            </div>
                        </div>

                        <hr class="mt-4" />
                        <div class="form-group row pt-2">
                            <div class="mx-auto">
                                <button class="btn btn-primary">Apply Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade @if(Session::get('tab') === 'itemmall') active show @endif" id="nav-im" role="tabpanel" aria-labelledby="nav-im-tab">
                    <div class="form-group">
                        <div class="d-flex w-100">
                            <div class="row">
                                <div class="col-12"><div class="subtitle" style="font-size: 1.2rem;">Item Mall Editor</div></div>
                                <div class="col-12"><div class="article pb-3" style="text-indent: 0;">A list of items that are displayed in <a href="{{ route('shop') }}" target="_blank">Item Mall</a>.</div></div>
                            </div>

                            <div class=" ml-auto" style="padding-left: 50px;">
                                <form method="POST" action="{{ route('admin') }}" class="d-inline">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="mode" value="itemmalllog">
                                    <button class="btn btn-primary">
                                        Download Logs
                                    </button>
                                </form>
                                <button class="btn btn-primary" onclick="showItemEditor(this, 1);">
                                    Add Item
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table pt-1">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">Item ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-center">Featured Label</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($itemMall as $data)
                                    <tr>
                                        <td class="align-middle text-center">{{ $data->item_id }}</td>
                                        <td class="align-middle">{{ $data->name }}</td>
                                        <td class="align-middle">{{ $data->getCategory() }}</td>
                                        <td class="align-middle text-center">{{ number_format($data->price) }}</td>
                                        <td class="align-middle text-center">{{ $data->max_quantity }}</td>
                                        <td class="align-middle text-center"><span class="badge @if($data->featured_label == 1)badge-success @elseif($data->featured_label == 2) badge-warning @else badge-secondary @endif">{{ $data->getFeaturedLabel() }}</span></td>

                                        <td class="d-flex justify-content-center align-middle">
                                            <button type="button" class="btn btn-secondary mr-1" style="padding: .375rem .75rem;"
                                                    data-itemid="{{ $data->item_id }}"
                                                    data-name="{{ $data->name }}"
                                                    data-description="{{ $data->description }}"
                                                    data-effects="{{ $data->effects }}"
                                                    data-category="{{ $data->category }}"
                                                    data-quantity="{{ $data->max_quantity }}"
                                                    data-price="{{ $data->price }}"
                                                    data-image="{{ $data->img }}"
                                                    data-label="{{ $data->featured_label }}"
                                                    data-subitems="{{ App\Models\ItemMallChild::where('MallItemID', $data->item_id)->get()->toJson() }}"
                                                    onclick="showItemEditor(this, 2);">
                                                <i class="far fa-edit"></i></button>

                                            <button type="button" class="btn btn-danger ml-1" style="padding: .375rem .75rem;"
                                                    data-id="{{ $data->item_id }}"
                                                    data-attributes='{"Name":"{{ $data->name }}","Category":"{{ $data->getCategory() }}","Price":"{{ number_format($data->price) }}"}'
                                                    onclick="showConfirmation(this, 'itemmall_delete')">
                                                <i class="far fa-trash-alt"></i></button>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center w-100">
                            {!! $itemMall->links() !!}
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if (Session::get('tab') === 'transactions') active show @endif" id="nav-topup" role="tabpanel" aria-labelledby="nav-topup-tab">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12"><div class="subtitle" style="font-size: 1.2rem;">Top Up Approvals</div></div>
                            <div class="col-12"><div class="article pb-3" style="text-indent: 0;">A list of top up transactions awaiting for manual approvals.</div></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table pt-1">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">User ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Date Issued</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center">Total Due</th>

                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $data)
                                    <tr>
                                        <td class="align-middle text-center">{{ $data->user_id }}</td>
                                        <td class="align-middle">{{ App\Models\User::find($data->user_id)->id_loginid }}</td>
                                        <td class="align-middle">{{ $data->getPaymentMethod() }}</td>
                                        <td class="align-middle">{{ $data->date_created }}</td>

                                        @if(!empty(App\Http\Controllers\DonateController::getPackageDetails($data->package)['item']))
                                            <td class="text-center">{{ App\Http\Controllers\DonateController::getPackageDetails($data->package)['item']['name'] }}</td>
                                        @else
                                            <td class="text-center">{{ number_format($data->cash_points) }} CP</td>
                                        @endif

                                        <td class="text-center align-middle">Rp. {{ number_format($data->price) }}</td>

                                        <td class="d-flex justify-content-center align-middle">
                                            <button type="button" class="btn btn-success mr-1" style="padding: .375rem .75rem;"
                                                onclick="showConfirmation(this, 'topup_add')"
                                                data-attributes='{"Name":"{{ App\Models\User::find($data->user_id)->id_loginid }}","Method":"{{ $data->getPaymentMethod() }}","Reference":"{{ $data->reference }}","Total Due":"Rp. {{ number_format($data->price) }}"}'
                                                data-id="{{ $data->transaction_id }}">
                                            <i class="fas fa-check"></i></button>

                                            <button type="button" class="btn btn-danger ml-1" style="padding: .375rem .75rem;"
                                                onclick="showConfirmation(this, 'topup_delete')"
                                                data-attributes='{"Name":"{{ App\Models\User::find($data->user_id)->id_loginid }}","Method":"{{ $data->getPaymentMethod() }}","Reference":"{{ $data->reference }}","Total Due":"Rp. {{ number_format($data->price) }}"}'
                                                data-id="{{ $data->transaction_id }}">
                                            <i class="far fa-trash-alt"></i></button>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center w-100">
                            {!! $transactions->links() !!}
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if (Session::get('tab') === 'referrals') active show @endif" id="nav-referrals" role="tabpanel" aria-labelledby="nav-referrals-tab">
                    <div class="form-group">
                        <div class="d-flex w-100">
                            <div class="row">
                                <div class="col-12"><div class="subtitle" style="font-size: 1.2rem;">Referrals Editor</div></div>
                                <div class="col-12"><div class="article pb-3" style="text-indent: 0;">A list of affiliated partners.</div></div>
                            </div>
                            <div class=" ml-auto" style="padding-left: 50px;">
                                <button class="btn btn-primary" onclick="showPartnerEditor(this, 1);">
                                    Add Partner
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table pt-1">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">User ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Referral Code</th>
                                    <th scope="col" class="text-center">Virtual Money</th>

                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($referrals as $data)
                                    <tr>
                                        <td class="align-middle text-center">{{ $data->userid }}</td>
                                        <td class="align-middle">{{ App\Models\User::find($data->userid)->id_loginid }}</td>
                                        <td class="align-middle">{{ $data->code }}</td>
                                        <td class="align-middle text-center">Rp. {{ number_format($data->virtual_money) }}</td>

                                        <td class="d-flex justify-content-center align-middle">
                                            <button type="button" class="btn btn-secondary mr-1" style="padding: .375rem .75rem;"
                                                    onclick="showPartnerEditor(this, 2)"
                                                    data-userid="{{ $data->userid }}"
                                                    data-name="{{ App\Models\User::find($data->userid)->id_loginid }}"
                                                    data-code="{{ $data->code }}"
                                                    data-money="{{ $data->virtual_money }}">
                                                <i class="far fa-edit"></i></button>

                                            <button type="button" class="btn btn-danger ml-1" style="padding: .375rem .75rem;"
                                                    onclick="showConfirmation(this, 'referrals_delete')"
                                                    data-attributes='{"User ID":"{{ $data->userid }}", "Name":"{{ App\Models\User::find($data->userid)->id_loginid }}", "Virtual Money":"Rp. {{ number_format($data->virtual_money) }}"}'
                                                    data-id="{{ $data->userid }}">
                                                <i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center w-100">
                            {!! $transactions->links() !!}
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade @if (Session::get('tab') === 'player') active show @endif " id="nav-player" role="tabpanel" aria-labelledby="nav-player-tab">
                    <div class="subtitle" style="font-size: 1.2rem;">Manage User</div>
                    <div class="article pb-2" style="text-indent: 0;">Type in the user of the user name of the player.</div>
                   <form id="playerForm">
                       @csrf
                       <input type="hidden" name="mode" value="playereditor">
                       <input type="hidden" name="action" value="0">
                       <div class="form-row align-items-center mb-5">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" name="userid" class="form-control" value="{{ old('userid') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary" onclick="showPlayerEditor(this);">Find</button>
                            </div>
                        </div>
                   </form>
                </div>

                <script>
                    function onDeliveryDataChange() {
                        var attributes = {};
                        var option = parseInt($('input[name="delivery_option"]:checked').val());
                        switch(option) {
                            case 1:
                                var jsonObject = $("#itemDeliveryName").tagsinput('items');
                                $.each(jsonObject, function (i, obj) {
                                    if (!attributes["Name"]) {
                                        attributes["Name"] = obj;
                                    } else {
                                        attributes["Name"] = attributes["Name"] + ", " + obj;
                                    }
                                });
                                break;
                            case 2:
                                attributes["Name"] = '<span class="text-primary">All Users</span>';
                                break;
                        }

                        attributes["Item ID"] = $("#itemDeliveryItemID").val();
                        attributes["Quantity"] = $("#itemDeliveryItemQty").val();

                        $('#itemDeliveryBtn').data('id', $("#itemDeliveryName").val());
                        $('#itemDeliveryBtn').data('attributes', attributes);
                    }

                    function onDeliveryOptionChange() {
                        $('#itemDeliveryName').prop('disabled', false);
                        var option = parseInt($('input[name="delivery_option"]:checked').val());
                        switch (option) {
                            case 1:
                                $('#itemDeliveryName').changeElementType('select');
                                $('#itemDeliveryName').attr('multiple', '');
                                $('#itemDeliveryName').attr('data-role', 'tagsinput');
                                $('#itemDeliveryName').attr('placeholder', 'Press enter for each user you want to add.');
                                $('#itemDeliveryName').removeAttr('type');
                                $('#itemDeliveryName').tagsinput('refresh');
                                $('#itemDeliveryName').tagsinput('removeAll');
                                $('#itemDeliveryOptionGroup').slideDown();
                                break;
                            case 2:
                                $('#itemDeliveryName').attr('placeholder', 'Item will be sent to all users.');
                                $('#itemDeliveryName').prop('disabled', true);
                                $('#itemDeliveryOptionGroup').slideUp();
                                break;
                        }
                    }
                </script>

                <div class="tab-pane fade @if (Session::get('tab') === 'items') active show @endif " id="nav-items" role="tabpanel" aria-labelledby="nav-items-tab">
                    <div class="subtitle" style="font-size: 1.2rem;">Item Delivery</div>
                    <div class="article pb-2" style="text-indent: 0;">Send items to the specified player.</div>
                    <form>
                        @csrf
                        <input type="hidden" name="mode" value="itemdelivery">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label pt-0">Send Type</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_option" value="1" onchange="onDeliveryOptionChange();" @if(old('delivery_option', 1) == 1) checked @endif>
                                    <label class="form-check-label" for="inlineRadio1">Select Users</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_option" value="2" onchange="onDeliveryOptionChange();" @if(old('delivery_option') == 2) checked @endif>
                                    <label class="form-check-label" for="inlineRadio2">All Users</label>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row" id="itemDeliveryOptionGroup">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10" id="itemDeliveryUsernameCol">
                                <select name="name" class="form-control" multiple data-role="tagsinput" id="itemDeliveryName" placeholder="Press enter for each user you want to add." onchange="onDeliveryDataChange();">
                                    @if(old('id', null) != null && !session()->has('status'))
                                        @php
                                            $names = json_decode(old('id', true));
                                        @endphp
                                        @foreach($names as $name)
                                            <option value="{{ $name }}"></option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Item ID</label>
                            <div class="col-sm-10">
                                <input id="itemDeliveryItemID" placeholder="Item ID" type="text" name="itemid" class="form-control h-auto" value="{{ old('itemid') }}" onchange="onDeliveryDataChange();">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Quantity</label>
                            <div class="col-sm-10">
                                <input id="itemDeliveryItemQty" name="quantity" class="form-control h-auto" type="number" value="0" min="1" step="1" max="100"  onchange="onDeliveryDataChange();" />
                                <small class="form-text text-muted pl-1">For non-consumables items, please set quantity to 1.</small>
                            </div>
                        </div>
                    </form>

                    <div class="form-group row pt-2">
                        <div class="mx-auto">
                            <button id="itemDeliveryBtn" class="btn btn-primary"
                                    data-id=""
                                    data-attributes=''
                                    onclick="onDeliveryDataChange(); showConfirmation(this, 'item_add')">Send</button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade @if (Session::get('tab') === 'report') active show @endif " id="nav-report" role="tabpanel" aria-labelledby="nav-report-tab">
                    @if(!Helper::isOwner())
                        <div class="subtitle" style="font-size: 1.2rem;">Not Authorized</div>
                        <div class="article pb-2" style="text-indent: 0;">You don't have permission to access this page.</div>
                    @else
                        <div class="subtitle" style="font-size: 1.2rem;">Transactions Report</div>
                        <div class="article pb-2" style="text-indent: 0;">Exports list of successful transactions in xls format.</div>
                        <form method="POST" action="{{ route('admin') }}">
                            @csrf
                            <input type="hidden" name="mode" value="report">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Start Date</label>
                                <div class="col-sm-10">
                                    <input id="startDate" type="text" name="date_start" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">End Date</label>
                                <div class="col-sm-10">
                                    <input id="endDate" type="text" name="date_end" class="form-control" value="">
                                </div>
                            </div>

                            <div class="form-group row pt-2">
                                <div class="mx-auto">
                                    <button class="btn btn-primary">Download Excel</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>


                <div class="tab-pane fade @if (Session::get('tab') === 'redeem') active show @endif" id="nav-redeem" role="tabpanel" aria-labelledby="nav-redeem-tab">
                    <div class="form-group">

                        <div class="d-flex w-100">
                            <div class="row">
                                <div class="col-12"><div class="subtitle" style="font-size: 1.2rem;">Manage Redeems</div></div>
                                <div class="col-12"><div class="article pb-3" style="text-indent: 0;">A list of redeem codes.</div></div>
                            </div>
                            <div class="article pb-2" style="text-indent: 0;">.</div>
                            <div class=" ml-auto" style="padding-left: 50px;">
                                <button class="btn btn-primary" onclick="showRedeemEditor(this, 1);">
                                    Add Code
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table pt-1">
                                <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col" class="text-center">Item ID</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-center">Claim Count</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($redeems as $data)
                                    <tr>
                                        <td class="align-middle">{{ $data->code }}</td>
                                        <td class="align-middle text-center">{{ $data->itemid }}</td>
                                        <td class="align-middle text-center">{{ $data->quantity }}</td>
                                        <td class="align-middle text-center">{{ number_format(App\Models\RedeemClaim::where('code', $data->code)->count()) }}</td>

                                        <td class="d-flex justify-content-center align-middle">
                                            <button type="button" class="btn btn-secondary mr-1" style="padding: .375rem .75rem;"
                                                    onclick="showRedeemEditor(this, 2)"
                                                    data-code="{{ $data->code }}"
                                                    data-itemid="{{ $data->itemid }}"
                                                    data-quantity="{{ $data->quantity }}">
                                                <i class="far fa-edit"></i></button>

                                            <button type="button" class="btn btn-danger ml-1" style="padding: .375rem .75rem;"
                                                    onclick="showConfirmation(this, 'redeem_delete')"
                                                    data-attributes='{"Code ":"{{ $data->code }}", "Item ID":"{{ $data->itemid }}", "Quantity":"{{ $data->quantity }}"}'
                                                    data-id="{{ $data->code }}">
                                                <i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center w-100">
                            {!! $transactions->links() !!}
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade @if (Session::get('tab') === 'ranking') active show @endif " id="nav-ranking" role="tabpanel" aria-labelledby="nav-ranking-tab">
                    <div class="subtitle" style="font-size: 1.2rem;">Top Up Ranking</div>
                    <div class="article pb-2" style="text-indent: 0;">Settings for donation leaderboard.</div>
                    <form method="POST" action="{{ route('admin') }}">
                        @csrf
                        <input type="hidden" name="mode" value="ranking">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="topup_ranking_status" id="inlineRadio1" value="1" {{ (boolean) Helper::getSetting('topup_ranking_status') ? 'checked' : null }}>
                                    <label class="form-check-label" for="inlineRadio1">Enable</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="topup_ranking_status" id="inlineRadio2" value="0" {{ (boolean) Helper::getSetting('topup_ranking_status') ? null : 'checked' }}>
                                    <label class="form-check-label" for="inlineRadio2">Disable</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Start Date</label>
                            <div class="col-sm-10">
                                <input id="startDate_topup" type="text" name="topup_ranking_start" class="form-control" value="{{ date("m/d/Y", Helper::getSetting('topup_ranking_start')) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">End Date</label>
                            <div class="col-sm-10">
                                <input id="endDate_topup" type="text" name="topup_ranking_end" class="form-control" value="{{ date("m/d/Y", Helper::getSetting('topup_ranking_end')) }}">
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <div class="mx-auto">
                                <button class="btn btn-primary">Apply Changes</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade @if (Session::get('tab') === 'tiered') active show @endif " id="nav-tiered" role="tabpanel" aria-labelledby="nav-tiered-tab">
                    <div class="subtitle" style="font-size: 1.2rem;">Tiered Spender</div>
                    <div class="article pb-2" style="text-indent: 0;">Settings for free rewards event.</div>
                    <form method="POST" action="{{ route('admin') }}">
                        @csrf
                        <input type="hidden" name="mode" value="tiered">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Event Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="tiered_spender_title" class="form-control" value="{{ Helper::getSetting('tiered_spender_title') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Start Date</label>
                            <div class="col-sm-10">
                                <input id="startDate_tier" type="text" name="tiered_spender_start" class="form-control" value="{{ date("m/d/Y", Helper::getSetting('tiered_spender_start')) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">End Date</label>
                            <div class="col-sm-10">
                                <input id="endDate_tier" type="text" name="tiered_spender_end" class="form-control" value="{{ date("m/d/Y", Helper::getSetting('tiered_spender_end')) }}">
                            </div>
                        </div>

                        <div class="form-group row pt-2">
                            <div class="mx-auto">
                                <button class="btn btn-primary">Apply Changes</button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="form-group">
                        <div class="d-flex w-100">
                            <div class="row">
                                <div class="col-12"><div class="subtitle" style="font-size: 1.2rem;">Tier Editor</div></div>
                                <div class="col-12"><div class="article pb-3" style="text-indent: 0;">A list of tier rewards.</div></div>
                            </div>
                            <div class=" ml-auto" style="padding-left: 50px;">
                                <button class="btn btn-primary" onclick="showTierEditor(this, 1);">
                                    Add Tier
                                </button>

                                <button class="btn btn-danger" onclick="showConfirmation(this, 'reset_tier')">
                                    Reset All
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table pt-1">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">Tier</th>
                                    <th scope="col">Goal</th>
                                    <th scope="col">Rewards</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($freeRewards->tiers as $index => $data)
                                    <tr>
                                        <td class="align-middle text-center">{{ $index + 1 }}</td>
                                        <td class="align-middle">Rp. {{ number_format($data->goal) }}</td>
                                        <td class="align-middle">
                                            @foreach($data->rewards as $reward)
                                                <span class="badge badge-secondary">{{ $reward->name }}</span>&nbsp;
                                            @endforeach
                                        </td>

                                        <td class="d-flex justify-content-center align-middle">
                                            <button type="button" class="btn btn-secondary mr-1" style="padding: .375rem .75rem;"
                                                    data-id="{{ $data->id }}"
                                                    data-goal="{{ $data->goal }}"
                                                    data-rewards="{{ $data->rewards->toJson() }}"
                                                    onclick="showTierEditor(this, 2)">
                                                <i class="far fa-edit"></i></button>

                                            <button type="button" class="btn btn-danger ml-1" style="padding: .375rem .75rem;"
                                                    data-id="{{ $data->id }}"
                                                    onclick="showConfirmation(this, 'tier_delete')">
                                                <i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center w-100">
                            {!! $transactions->links() !!}
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <script>
        window.onload = function () {
            $('#startDate_topup').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
            $('#endDate_topup').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
            $('#startDate_tier').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });
            $('#endDate_tier').datepicker({
                uiLibrary: 'bootstrap4',
                iconsLibrary: 'fontawesome',
            });

            $('#modalItemEditorCategory').on('change', function() {
                $('#modalItemEditorQty').attr('value', '1');
                if (this.value == 4) {
                    $('#modalItemEditorQty').attr('min', '1');
                    $('#modalItemEditorQty').attr('max', '100');
                    $("#subItemsWrapper").fadeIn();
                    $("#modalItemEditorEffectsRow").hide();
                } else {
                    $('#modalItemEditorQty').attr('min', '1');
                    $('#modalItemEditorQty').attr('max', '1');
                    $("#subItemsWrapper").hide();
                    $("#modalItemEditorEffectsRow").fadeIn();
                }
            });

            $('#itemDeliveryUsernameCol > .bootstrap-tagsinput > input').on('paste', function (e) {
                var pastedData = e.originalEvent.clipboardData.getData('text');
                var array = pastedData.match(/[^\s]+/g);
                $.each(array, function( index, value ) {
                    $('#itemDeliveryName').tagsinput('add', value);
                });

                e.preventDefault();
            });

            $("#subItemsWrapper").on("click", "#addSubItem", function(e){
                e.preventDefault();
                var subitems = JSON.parse($('#modalItemEditorSubItems').val());
                subitems.push({"MallItemID": $('#modalItemEditorId').val(),"Name":"","Image":""});
                $("#subItems").append('<div class="input-group mt-2"> <input onfocus="this.oldvalue = this.value;" onchange="subItemsOnChange(this)"  type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off"> <div class="input-group-append"> <button type="button" class="btn btn-danger removeSubItem">-</button> </div> <div class="custom-file" style="margin-left: 7px; padding-left: 60px;"> <input onchange="subItemsOnChange(this)" type="file" class="custom-file-input" name="sub_item_img[]"> <label class="custom-file-label"></label> </div> </div>');
                $('#modalItemEditorSubItems').val(JSON.stringify(subitems));
                $("input[type='number']").inputSpinner();
            });

            $("#subItemsWrapper").on("click", ".removeSubItem", function(e){
                e.preventDefault();
                var subitems = JSON.parse($('#modalItemEditorSubItems').val());
                var itemName = $(this).parents(".input-group").find('input:eq(0)').val();
                for (let [i, subitem] of subitems.entries()) {
                    if (subitem.Name == itemName) {
                        subitems.splice(i, 1);
                        break;
                    }
                }

                $(this).parents(".input-group").remove();
                $('#modalItemEditorSubItems').val(JSON.stringify(subitems));
            });

            let tierCount = 1;

            $("#rewardsWrapper").on("click", "#addRewardItem", function(e){
                tierCount++;
                e.preventDefault();
                $("#rewards").append('<div class="rewardItem"><hr class="hr-text" data-content="Reward #' + tierCount + '"> <div class="input-group mb-2"> <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-default">Item Name</span> </div> <input type="text" name="sub_item_name[]" class="form-control m-input" placeholder="Item Name" autocomplete="off"> <div class="input-group-prepend ml-2"> <span class="input-group-text" id="inputGroup-sizing-default">Item ID</span> </div> <input type="text" name="sub_item_id[]" class="form-control m-input" placeholder="Item ID" autocomplete="off"><input type="hidden" name="sub_item_reward_id[]"> </div> <div class="input-group mb-2"> <input data-prefix="Quantity" type="number" name="sub_item_quantity[]" class="form-control m-input h-auto" autocomplete="off" value="1" min="0" step="1"> </div> <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text" id="inputGroup-sizing-default">Image File</span> </div> <div class="custom-file" style="padding-left: 60px;"> <input type="file" class="custom-file-input" name="sub_item_img[]" placeholder="Image File"> <label class="custom-file-label">No file chosen</label> </div> <div class="input-group-append"> <button type="button" class="btn btn-danger removeSubItem">-</button> </div></div></div>');
                $('.hr-text').each(function(i, obj) {
                    $(this).attr('data-content', 'Reward #' + (i + 1));
                });
            });

            $("#rewardsWrapper").on("click", ".removeSubItem", function(e){
                e.preventDefault();

                $(this).parents(".rewardItem").remove();
                $('.hr-text').each(function(i, obj) {
                    $(this).attr('data-content', 'Reward #' + (i + 1));
                });
            });
        }
    </script>
@stop
