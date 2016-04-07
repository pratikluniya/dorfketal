function consignmentId(consignmentid)
{
    var consinement=$("#consignmentid").val(consignmentid);
    $.ajax({
        type: "POST",
        url:"logistics/ajax_service.php",
        data:"consignment_id="+consignmentid+"&action=select_update_consignment",
        dataType:"JSON",
        success: function(data)
        {
            if(data !="no")
            {
                $("#consignmentid").val(data[0].consignment_id);
                $("#consigneeaddress").val(data[0].consignment_address);
                $("#modeofshipment").val(data[0].mode_of_shipment);
                $("#vesselname").val(data[0].vessel_name);
                $("#etd").val(data[0].etd_date);
                $("#shippedonboard").val(data[0].shipped_on_board);
                $("#containername").val(data[0].container_number);
                $("#transhipmentport").val(data[0].transhipment_port);
                $("#transhipmentvesselname").val(data[0].transhipment_vessel_name);
                $("#eta").val(data[0].eta_date);
                $("#arrivaldate").val(data[0].arrival_date);                            
                if(data[0].arrival_date == null || data[0].arrival_date == "" || data[0].arrival_date == '' || data[0].arrival_date == null)
                {
                    $("#customclearance").attr('disabled', 'disabled');
          		    $("#customclearance").attr('readonly', 'true');
                } 
                else
                {
              	    $("#customclearance").removeAttr('disabled');
                    $("#customclearance").removeAttr('readonly');
              	}
                if(data[0].custom_clearance =="yes")
                {
                    $(':checkbox').prop('checked', true);
                }
                else
                {
              	    $(':checkbox').prop('checked', false);
                } 
                if(data[0].custom_clearance =="yes")
                {
              	    $("#customclearancedate").val(data[0].custom_clearance_date).attr('readonly',false); 
              	    $("#custdelivered").val(data[0].delivered_cutomer_loaction).attr('readonly',false);
              	}
                else
                {
              	    $("#customclearancedate").val(data[0].custom_clearance_date).attr('readonly','readonly'); 
         	        $("#custdelivered").val(data[0].delivered_cutomer_loaction).attr('readonly','readonly');
                }
                $("#remark").val(data[0].remark);
                if(data[0].container_number == null || data[0].container_number == "" || data[0].container_number == '')
                {
                    $("#liknktraking").html("<spam>Container Number</spam>");
                }
                else
                { 
                    if(data[0].container_url == null || data[0].container_url=="" || data[0].container_url =='')
                    {
                 	    $("#edit_container_url").val(data[0].url_logistic);
                 	    $("#add_btn_url").html('<input type="button"  name="btn_edit" id="btn_edit" value="Edit Url" class="col-md-2" onclick="return container_edit_url('+data[0].delivery_details_id+');"/>');
                 	    $("#liknktraking").html("<span class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='.bs-example-modal-lg6' name='btn_tracking' id='btn_tracking' /></span><span style='margin-left:5px;'>Container Number</span><a style='color:#7d8bf0;margin-left: 10px;' href='"+data[0].url_logistic+data[0].container_number+"' style='margin-left:10px; color:green;' target='_blank'>View</a>");
                    }
                    else
                    {
                 	    $("#add_btn_url").html('<input type="button"  name="btn_edit" id="btn_edit" value="Edit Url" class="col-md-2" onclick="return container_edit_url('+data[0].delivery_details_id+');"/>');
                 	    $("#add_default_url").html('<input type="button"  name="btn_edit" id="btn_edit" value="Default Url" class="col-md-2" onclick="return container_default_url('+data[0].delivery_details_id+');"/>');
                 	    $("#edit_container_url").val(data[0].container_url);
                 	    $("#liknktraking").html("<span class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='.bs-example-modal-lg6' name='btn_tracking' id='btn_tracking' /></span><span style='margin-left:5px;'>Container Number</span><a style='color:#7d8bf0;margin-left: 10px;' href='"+data[0].container_url+"' style='margin-left:10px; color:green;' target='_blank'>View</a>");
                    }
                } 
            }
        }
    }); 
}
function showdocument(consignment_id)
{
    var consigmantid=$("#consignmentid1").val(consignment_id);   
    $.ajax({
        type:"POST",
        url:"logistics/ajax_service.php",
        data:"consigment_id="+consignment_id+"&action=showdocument",
        dataType:"JSON",
        success: function(data)
        {
            var  data1 = $.parseJSON(data[0].shipping_document_details);
            $("#serviceprovider").val(data[0].service_provider);
            $("#createddate").val(data[0].created_date);
            if(data1.bill_of_laden != 'undefined')
            { 
                $('#bill_of_laden').prop('checked', true);              
            }
            if(data1.packing_list != 'undefined')
            {           
                $('#packing_list').prop('checked', true);             
            }
            if(data1.certificate_of_analysis != 'undefined')
            { 
                $('#certificate_of_analysis').prop('checked', true);              
            }
            if(data1.certificate_of_origin != 'undefined')
            {             
                $('#certificate_of_origin').prop('checked', true);       
            }
            if(data1.gsp != 'undefined')
            {
                $('#gsp').prop('checked', true);
            }
            if(data1.haz_declaraition != 'undefined')
            {
                $('#haz_declaraition').prop('checked', true);      
            }
            if(data1.non_hAZ_declaraition != 'undefined')
            {
                $('#non_hAZ_declaraition').prop('checked', true);               
            }
            if(data1.msds != 'undefined')
            {
                $('#msds').prop('checked', true);               
            }
            if(data1.heat_treatment_certification != 'undefined')
            {
                $('#heat_treatment_certification').prop('checked', true);             
            }
            if(data1.benificary_declaration != 'undefined')
            {
                $('#benificary_declaration').prop('checked', true);         
            }
            if(data1.certificate_quantity != 'undefined')
            {
                $('#certificate_quantity').prop('checked', true);                     
            }
            var trHTML = '<table class="table"><tr><th>Document Type</th><th><strong>Document Name</strong></th><th><strong>Upload Date</strong></th><th><strong>Action<strong></th></tr>';
            var newHtml="";
            if((data[0].shipping_document != "") && (data[0].shipping_document !=null))
            {
                trHTML+='<tr id="rows"><td>Shipping Document</td><td><a  href="uploaded/'+ data[0].shipping_document+'">'+ data[0].shipping_document+'</a></td><td>'+data[0].shipping_document_update+'</td><td><a  href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'s'"+');">Delete</a></td></tr>';
            }
            if((data[0].commercial_invoice != "") && (data[0].commercial_invoice !=null) )
            {  
                trHTML+='<tr id="rowc"><td>Commercial Invoice</td><td><a  href="uploaded/'+ data[0].commercial_invoice+'">'+ data[0].commercial_invoice+'</a></td><td>'+data[0].commercial_invoice_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'c'"+');">Delete</a></td></tr>';
            }
            if((data[0].india_commercial_invoice != "") && (data[0].india_commercial_invoice !=null) )
            {  
                trHTML+='<tr id="rowi"><td>India Commercial Invoice</td><td><a  href="uploaded/'+ data[0].india_commercial_invoice+'">'+ data[0].india_commercial_invoice+'</a></td><td>'+data[0].india_commercial_invoice_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'i'"+');">Delete</a></td></tr>';
            }
            trHTML+='</table>';
            $('#targetLayer').html(trHTML);
        }
    });
}
function deleteDocument(consignmentid_delete,document_delete)
{ 
    $.ajax({  
        type:"POST",
        url:"logistics/ajax_service.php",
        data:"consignment_id="+consignmentid_delete+"&document_type="+document_delete+"&action=deleteDocument",     
        success: function(data)
        {
            if(data == "success")
            {

              	$("#pop").html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"aria-label="Close"><span aria-hidden="true">×</span></button>You have successfully deleted document</div>');
                $("#pop").fadeOut(5000);
                $("#row"+document_delete).removeAttr().fadeOut(5000);
                var expload= function()
                {
                    location.reload();
                };
                setTimeout(expload,5001);
            }
        }
    });  
}
function datechaneg()
{
    var datesd= $("#fromdate").val();
    $("#fromdate").val(datesd);
}
function insertshipment()
{
    var consignmentid=$("#consignmentid").val();
    var consigneeaddress=$("#consigneeaddress").val();
    var modeofshipment=$("#modeofshipment").val();
    var vesselname=$("#vesselname").val();
    var etd=$("#etd").val();
    var shippedonboard=$("#shippedonboard").val();
    var containername=$("#containername").val();
    var transhipmentport=$("#transhipmentport").val();
    var transhipmentvesselname=$("#transhipmentvesselname").val();
    var eta=$("#eta").val();
    var arrivaldate=$("#arrivaldate").val();
    var customclearancedate=$("#customclearancedate").val();      
    var custdelivered=$("#custdelivered").val();
    var remark=$("#remark").val();      
    if($("#customclearance").prop("checked") == false)
    {
        var customclearance="NA";        
    }
    else
    {
        var customclearance=$("#customclearance").val();
    }
    if(arrivaldate == null || arrivaldate =="" || arrivaldate == '')
    {
        customclearance = $("#customclearance").prop("checked") == false;
        customclearance="NA";
        var customclearancedate=$("#customclearancedate").val(" ");      
        var custdelivered=$("#custdelivered").val(" ");
    }
      
    $.ajax({
        type: "POST",
        url:"logistics/ajax_service.php",
        data:"consignment_address="+consigneeaddress+"&mode_of_shipment="+modeofshipment+"&vessel_name="+vesselname+"&etd_date="+etd+"&shipped_on_board="+shippedonboard+"&container_name="+containername+"&transhipment_port="+transhipmentport+"&transhipment_vessel_name="+transhipmentvesselname+"&eta_date="+eta+"&arrival_date="+arrivaldate+"&custom_clearance_date="+customclearancedate+"&custom_clearance="+customclearance+"&delivered_cutomer_loaction="+custdelivered+"&remark="+remark+"&consignment_id="+consignmentid+"&action=insertupdateconsignment",
        success: function(data)
        {
            alert(data);
            console.log(data);
            $("#kk_pop").hide();
        }
    });
}
function container_edit_url(delivery_details_id) 
{
    var tracking_url=$("#edit_container_url").val();
    var r =confirm("Are you sure you want to update url");
    if(r == true)
    {   
        $.ajax({
            url: "logistics/ajax_service.php",
            data : "tracking_url="+tracking_url+"&delivery_details_id="+delivery_details_id+"&action=container_url_edit",
            success:function(data){ 
                alert(data);
                location.reload();
            }
        });
    }
    else
    {

    }
}
function container_default_url(delivery_details_id) 
{
    var r =confirm("Are you sure you want to update url");
    if(r == true)
    {
        $.ajax({
            url: "logistics/ajax_service.php",
            data : "delivery_details_id="+delivery_details_id+"&action=container_Default_url",
            success:function(data){ 
                alert(data);
            }
        });
    }
    else
    {
    
    }
}
function hide_pop()
{
    $("#kk_pop").hide();
}
function showshipmentdetails (consignmentid)
{
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data:"consignment_id="+consignmentid+"&action=customershippeddetails",
        dataType:"JSON",
        success: function(data)
        {
            var data_html='<table class="table" style="width: 182%; max-width: 174%;">'
            +'<tr><td style="width: 56%;">Purchase Order Number</td><td>'+data[0].cust_po_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Consignee Address</td><td>'+data[0].consignment_address+'</td></tr>'
            +'<tr><td style="width: 56%;">Mode Of Shipment</td><td>'+data[0].mode_of_shipment+'</td></tr>'
            +'<tr><td style="width: 56%;">Vessel Name</td><td>'+data[0].vessel_name+'</td></tr>'
            +'<tr><td style="width: 56%;">Expected Date Of Departure</td><td>'+data[0].etd_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Container Number</td><td><a href="'+data[0].url_logistic+data[0].container_number+'">'+data[0].container_number+'</a></td></tr>'
            +'<tr><td style="width: 56%;">Shipped On Board</td><td>'+data[0].shipped_on_board+'</td></tr>'
            +'<tr><td style="width: 56%;">Transhipment Port</td><td>'+data[0].transhipment_port+'</td></tr>'
            +'<tr><td style="width: 56%;">Transhipment Vessel Name</td><td>'+data[0].transhipment_vessel_name+'</td></tr>'
            +'<tr><td style="width: 56%;">Expected Date Of Arrival</td><td>'+data[0].eta_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Arrival Date @ Destination</td><td>'+data[0].arrival_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Customer clearance Date</td><td>'+data[0].custom_clearance_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Delivered at Customer Location</td><td>'+data[0].delivered_cutomer_loaction+'</td></tr>'
            +'<tr><td style="width: 56%;">Document Courier tracking Number</td><td>'+data[0].purchase_order_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Document Corier Tracking Date</td><td>'+data[0].purchase_order_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Document Corier Tracking Service</td><td>'+data[0].purchase_order_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Remark</td><td>'+data[0].remark+'</td></tr>'
            +'</table>';
            $("#showshipmentdetails").html(data_html);
        }
    });
}
function show_option(option_val)
{
    if(option_val=="Shipping Documents")
    {
        $(".option_div").removeClass("hide");
    }
    else
    {
        $(".option_div").addClass("hide");
    }
}