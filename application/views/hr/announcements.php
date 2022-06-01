<head><title>Announcements | InfoSys</title></head>
<style type="text/css">
  .closer:hover,.lock:hover {
    color: green;
    font-weight: 600;
    cursor: pointer;
}
</style>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
          
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="javascript:history.back();"><i class="btn-xl fa fa-arrow-circle-o-left"></i></a></li>
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo base_url('dashboard');?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="icon-drawer"></i>
                        <a href="#">Announcements</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            
            <div class="portlet light bordered" style="max-width: 700px;margin: auto;}">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-bullhorn font-red-sunglo"></i>
                        <span class="caption-subject font-red-sunglo  uppercase">Announcements</span>
                        <span class="caption-helper">Manage announcements</span>
                    </div>
                    <div class="actions hidden">
                        <a class="btn btn-danger btn-sm" data-toggle='modal' onclick="loadOR()" href='#mOR'><i class="fa fa-file-text-o"></i> View by Receipts</a>
                    </div>
                </div>
                <div class="portlet-body form">

                  <?php 

                    if(in_array(3, $this->session->userdata('uroles'))){
                      $hr = 1;
                      echo '<div class="row">
                                <div class="announcement d-flex p-3" style="padding: 2rem;    margin-bottom: 5rem;">
                                  <div class="blog-comments__content">
                                    <div>
                                      <label>Title</label>
                                      <input type="text" id="a_title" class="form-control text-secondary" placeholder="Title" style="border: 1px solid #005788;">
                                    </div>

                                    <div>
                                        <br><br>
                                        <label>Announcement Body</label>
                                        <textarea class="form-control" id="a_body" placeholder="Announcement" style="border: 1px solid #005788;"></textarea>
                                        <button class="btn btn-primary" style="float:right;margin-top:5px;" onclick="post_announcement()"> Post Announcement</button>
                                    </div>
                                  </div>
                                </div>       
                            </div>
                            <hr>';
                    }
                    else{
                      $hr = 0;
                    }
          
            ?>
                    
                    <div id="post_board" >
                
                      <?php
                        foreach ($announcements as $an) {
                          $pinned = '<div class="blog-comments__meta tr" style="float:right">
                                    <i class="fa fa-'.($an->pinned == '1'?'lock':'unlock'). ' lock" onclick="update_announce('.($an->pinned == '1'?'0':'1'). ', '.$an->id.')"></i>'.
                                    ($hr ==1?'<i class="fa fa-pencil closer" onclick="editAnnounce(3, '.$an->id.')"></i> <i class="fa fa-times closer" onclick="update_announce(3, '.$an->id.')"></i>':'').'</div> ';
                          echo  '<div class="announcement d-flex p-3">
                            <div class="blog-comments__content" id="anno'.$an->id.'">'. $pinned .
                              '<div class="blog-comments__meta text-muted">
                                <a class="text-secondary" href="#" style="font-weight: 800;">'.$an->title.'</a> 
                                <input style="display:none;" type="text" class="form-control" value="'.$an->title.'">
                                <br><span class="announce_date">'. $an->date_create.'</span>
                              </div>
                              <br>
                              <p class="m-0 my-1 mb-2 text-muted">'. str_replace("\n","<br>",$an->body).'</p>
                              <textarea style="display:none" class="form-control">'.$an->body.'</textarea>
                              <button style="display:none" class="btn btn-primary btn-block uppercase" onclick="updateAnnounce('.$an->id.')">Save</button>
                            </div>
                          </div><hr>';
                        }
                      ?>


                      </div>
                </div>
            </div>
           
        </div>
    </div>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<script type="text/javascript">
let a_url= '<?php echo base_url()?>/hr/';
	function post_announcement(){
  a_title = $('#a_title').val();
  a_body = $('#a_body').val();
  if(a_body != '' && a_body != ''){
    $.ajax({
      url: a_url + 'Announcements/save_announcement',
      type: 'post',
      data: {
        a_title: a_title,
        a_body: a_body     
      },
      success: function(d){
        $('#a_title, #a_body').val('');
        get_announcements();
      }
    });
  }
}
function get_announcements(){
  $.ajax({
    url: a_url+ 'Announcements/get_announcements',
    async: false,
    success: function(d){
      if(d != ''){
        $('#post_board').empty();
        
        $.each(d, function(i, rs){

         let pinned ='<div class="blog-comments__meta tr" style="float:right"><i class="fa fa-'+(rs.pinned == '1'?'lock':'unlock')+' lock" onclick="update_announce('+(rs.pinned == '1'?0:1)+', '+rs.id+')"></i> '+
         '<i class="fa fa-pencil closer" onclick="editAnnounce(3, '+rs.id+')"></i> <i class="fa fa-times closer" onclick="update_announce(3, '+rs.id+')"></i></div>';
          
          
          $('#post_board').append('<div class="announcement d-flex p-3">'+
            '<div class="blog-comments__content" id="anno'+rs.id+'">'+ pinned +
              '<div class="blog-comments__meta text-muted">'+
                '<a class="text-secondary" href="#">'+rs.title+'</a> '+
                '<input style="display:none;" type="text" class="form-control" value="'+rs.title+'"  style="font-weight: 800;">'+
                '<br><span class="announce_date">'+rs.date_create+'</span>'+
              '</div><br>'+
              '<p class="m-0 my-1 mb-2 text-muted">'+ rs.body.replace(/\n/g, "<br />")+'</p>'+
              '<textarea style="display:none" class="form-control">'+rs.body+'</textarea>'+
              '<button style="display:none" class="btn btn-primary btn-block uppercase" onclick="updateAnnounce('+rs.id+')">Save</button>'+
            '</div>'+
          '</div>');
        });
      }
      else{
          $('#post_board').html('<div class="announcement d-flex p-3">'+
            '<div class="blog-comments__content text-center">'+
              '<p class="m-0 my-1 mb-2 text-muted">Nothing to see here.</p>'+
            '</div>'+
          '</div>');
      }
    }
  });
}

function update_announce(act, id){
  $.ajax({
    url: a_url+ 'Announcements/update_announcement',
    type: 'post',
    data: {act: act,id: id},
    success: function(d){
      get_announcements();
    }
  });
}

function updateAnnounce(id){
  title = $('#anno'+id + ' input').val();
  body = $('#anno'+id+' textarea').val();
  $.ajax({
    url: a_url+ 'Announcements/update_announcement2',
    type: 'post',
    data: {id: id, title: title, body:body},
    success: function(d){
       get_announcements();
    }
  });
}

function editAnnounce(act, id){
  $('#anno'+id + ' input, #anno'+id+' textarea, #anno'+id+' button').show();
  $('#anno'+id + ' p, #anno'+id+' a').hide();
}
</script>