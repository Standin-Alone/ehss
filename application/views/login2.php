<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PNRI InfoSys</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="<?php echo base_url('/assets/login/logo.png')?>">
    <link rel="stylesheet" href="<?php echo base_url('/assets/login/bootstrap.min.css')?>">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="<?php echo base_url('/assets/login/shards-dashboards.1.1.8.css')?>">
    <script src="<?php echo base_url('/assets/login/jquery.js')?>"></script>
    <script defer src="<?php echo base_url();?>assets/peach/js/mylibs/jquery.validate.js"></script>
<!--TEST -->
    <style type="text/css">
  body{
    color:#292929;
    background:white;
  }
  p{
    font-weight: 400;
  }
  red{
    color: red;
    font-weight: 600;
  }
  .bootstrap-tagsinput{
    height: 35px;
  }
  .article-content{
    padding: 0 !important;
  }
  .asearch select{
    font-size: 14px;
    height: 50px;
    width: 75px;
  }
  #about{
    /*overflow-y: scroll;*/
  }
  #about p {
    font-size: 11pt;
    font-weight: 400;
    line-height: 16pt
  }
  .bootstrap-tagsinput input{
    height: 50px;
  }
  .announcement p {
        font-size: 13px;
        font-weight: 400;
        margin-top: 1rem !important;
      }
  .announce_date{
        font-size: 12px;
        color: #585858;
        font-weight: 400;
      }
      material:hover, .announcement:hover{
        box-shadow: 0 1px 20px #999;
        opacity: 0.95;
      }
  .nav-blue{
    margin-top: 0.5rem;
    -webkit-filter: drop-shadow(2px 4px 3px rgba(0,0,0,0.3));filter: drop-shadow(2px 4px 3px rgba(0,0,0,0.3));
    text-align: center;
  }

  .bsearch .bootstrap-tagsinput{border:0;}


  .btn-white{
    height: 57px;
  }
  .cat-label{
    top:-18px;
  }
  .bsbt{
    position: absolute;
    top: 0;
    right: 0;
  }
  .box {
  width: 200px; height: 300px;
  position: relative;
  border: 1px solid #BBB;
  background: #EEE;
}

.subnav {
    float: left;
    overflow: hidden;
  }

  .subnav .subnavbtn {
    font-size: 16px;
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
  }

  .navbar a:hover, .subnav:hover .subnavbtn {
    background-color: #023958;
  }

  ul.portal{
    margin: 0;
  }

.display-hide, .display-none {
    display: none;
}

  #navbar-container{
    padding-top:2px;background-image:linear-gradient(rgba(13,99,148,0.79), rgba(13,99,148,0.79)),url('assets/images/reactor_side.jpg');
    background-size: cover;
    height: 80px;
  }

  .btn-red {
    color: #fff;
    background-color: #e7505a;
    border-color: #e7505a;
}
.main-content > .main-content-container.container-fluid {
    min-height: calc(100vh - 24.5rem);
}
.announcement {
    border-bottom: 1px solid #d0cfcf;
    position: relative;
}


/* width */
.preview_content::-webkit-scrollbar {
  width: 2px;
}

/* Track */
.preview_content::-webkit-scrollbar-track {
  background: #e4e3e3;
}

/* Handle */
.preview_content::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
.preview_content::-webkit-scrollbar-thumb:hover {
  background: #555;
}


/* width */
#post_board::-webkit-scrollbar {
  width: 2px;
}

/* Track */
#post_board::-webkit-scrollbar-track {
  background: #e4e3e3;
}

/* Handle */
#post_board::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
#post_board::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* width */
#about::-webkit-scrollbar {
  width: 2px;
}

/* Track */
#about::-webkit-scrollbar-track {
  background: #e4e3e3;
}

/* Handle */
#about::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
#about::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.article-min{
  max-height: 200px;
  overflow-y: hidden;
}
#article_board > div{
  margin-bottom: 1rem;    width: 100%;border: 1px solid; margin: 1em;background: white;
}
.expand{
  position: absolute;
  bottom: 0;
  right: 0;
  background: white;
  padding: 2px 1rem;
  color: blue;
  cursor: pointer;
  font-weight: 600;
}
.loader {
  border: 2px solid #ffffff;
  border-radius: 50%;
  border-top: 2px solid #00aeef;
  width: 15px;
  height: 15px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 1s linear infinite;
  margin-right: 10px;
}
.error{
  height: unset;
  color:#fb3333;
}
.read-more{
  color: blue;
}
.topc {
  border-bottom: 1px solid #fff;
}
.main-sidebar{
  top:50px;
}
.post-title{
  font-size: 13pt;color:#4084ab;line-height: 20px;
}
.topc,.opc {
  font-size: 12pt;
}
table {
    border-collapse: collapse;
    font-size: 9pt;
    font-weight: 500;
}
.aside-nav{
  list-style: none;padding-left: 0;
}
.aside-nav li:hover {
    background: #ececec
}
.aside-nav li{
  padding: 0.70em;
  display: flex;
  border-top: 0;
  transition: background 0.3s ease;
  cursor: pointer;
}
.post-img{
  cursor: pointer;
  height: 400px;
}
.post-textbody{
  position: relative;
}

#view-post-modal{
  width: 100%;height: 100vh; background: white;display: flex; position: fixed;z-index: 99999;
}
#new-post-modal{
  width: 100%;
  height: 100vh;
  background: #c7c7c78c;
  display: flex;
  position: fixed;
  z-index: 99999;
}
.closer {
  cursor: pointer;
}
.closer:after, .closer:before {
  content: "";
  height: 30px;
  width: 30px;
  border-top: 2px solid #000;
  position: absolute;
  top: 16px;
  right: -4px;
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  transform: rotate(-45deg);
}
.closer:before {
  right: 15px;
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}
.closer:hover {
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=30);
  opacity: 0.3;
}
.btn:hover{border:1px solid #f1111f;background-color:#f1111f;}

#announcement_div{
  width:450px;
  border: 1px solid #ececec;
  margin-left: auto;
  background: white;
  padding: 0;
}


/* width */
#new-post-modal::-webkit-scrollbar {
  position: absolute; z-index: 9999;
}

/* Track */
#new-post-modal::-webkit-scrollbar-track {
  position: absolute; z-index: 9999;
}

/* Handle */
#new-post-modal::-webkit-scrollbar-thumb {
  position: absolute; z-index: 9999;
}

/* Handle on hover */
#new-post-modal::-webkit-scrollbar-thumb:hover {
  position: absolute; z-index: 9999;
}


/*LIKE */


div.like {
  position: relative;
  margin: 15px auto;
  margin-bottom: 0;
  position: relative;
}

.like i {
  cursor:pointer;
  padding:10px 12px 8px;
  background:#fff;
  border-radius:50%;
  display:inline-block;
  margin:0 0 15px;
  color:#aaa;
  transition:.2s;
  -webkit-box-shadow: -2px 0px 14px -2px rgb(0 0 0 / 30%);
  box-shadow: -2px 0px 14px -2px rgb(0 0 0 / 30%);
}
.lbtn{
  color:#e23b3b;
  margin-left:1em;
}
.like i:hover {
  color:#666;
}

.like i:before {
  font-style:normal;
  font-family:fontawesome;
  content:'\f004';
}
.disabled{
  opacity: 0.4;
}
.like i.press {
  animation: size .4s;
  color:#e23b3b;
}
.preview_content{
  margin-top: 3em;
  padding: 1em;
  padding-top: 0;
  overflow-y: scroll;max-height: 100%;
}
.aside-nav li.active{
  background:#d3ebf9;
}

input.post {
  background: 0;
  border: 0;
  outline: none;
  width: 100%;
  max-width: 400px;
  font-size: 13pt;
  transition: padding 0.3s 0.2s ease;
}
input.post:focus {
  padding-bottom: 5px;
}
input.post:focus + .line:after {
  transform: scaleX(1);
}
.field {
  position: relative;
}
.field .line {
  width: 100%;
  height: 3px;
  position: absolute;
  bottom: -8px;
  background: #bdc3c7;
}
.field .line:after {
  content: " ";
  position: absolute;
  float: right;
  width: 100%;
  height: 3px;
  transform: scalex(0);
  transition: transform 0.3s ease;
  background: #4084ab;
}


.pure-material-button-contained {
  position: relative;
  display: inline-block;
  box-sizing: border-box;
  border: none;
  border-radius: 4px;
  padding: 0 16px;
  min-width: 64px;
  height: 36px;
  vertical-align: middle;
  text-align: center;
  text-overflow: ellipsis;
  text-transform: uppercase;
  color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
  background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
  box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
  font-family: var(--pure-material-font, "Roboto", "Segoe UI", BlinkMacSystemFont, system-ui, -apple-system);
  font-size: 14px;
  font-weight: 500;
  line-height: 36px;
  overflow: hidden;
  outline: none;
  cursor: pointer;
  transition: box-shadow 0.2s;
}

.pure-material-button-contained::-moz-focus-inner {
    border: none;
}

/* Overlay */
.pure-material-button-contained::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
    opacity: 0;
    transition: opacity 0.2s;
}

/* Ripple */
.pure-material-button-contained::after {
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    border-radius: 50%;
    padding: 50%;
    width: 32px; /* Safari */
    height: 32px; /* Safari */
    background-color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
    opacity: 0;
    transform: translate(-50%, -50%) scale(1);
    transition: opacity 1s, transform 0.5s;
}

/* Hover, Focus */
.pure-material-button-contained:hover,
.pure-material-button-contained:focus {
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12);
}

.pure-material-button-contained:hover::before {
    opacity: 0.08;
}

.pure-material-button-contained:focus::before {
    opacity: 0.24;
}

.pure-material-button-contained:hover:focus::before {
    opacity: 0.3;
}

/* Active */
.pure-material-button-contained:active {
    box-shadow: 0 5px 5px -3px rgba(0, 0, 0, 0.2), 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12);
}

.pure-material-button-contained:active::after {
    opacity: 0.32;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0s;
}

/* Disabled */
.pure-material-button-contained:disabled {
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
    background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.12);
    box-shadow: none;
    cursor: initial;
}

.pure-material-button-contained:disabled::before {
    opacity: 0;
}

.pure-material-button-contained:disabled::after {
    opacity: 0;
}

.pure-material-checkbox {
    z-index: 0;
    position: relative;
    display: inline-block;
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
    font-family: var(--pure-material-font, "Roboto", "Segoe UI", BlinkMacSystemFont, system-ui, -apple-system);
    font-size: 16px;
    line-height: 1.5;
}

/* Input */
.pure-material-checkbox > input {
    appearance: none;
    -moz-appearance: none;
    -webkit-appearance: none;
    z-index: -1;
    position: absolute;
    left: -10px;
    top: -8px;
    display: block;
    margin: 0;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    box-shadow: none;
    outline: none;
    opacity: 0;
    transform: scale(1);
    pointer-events: none;
    transition: opacity 0.3s, transform 0.2s;
}

/* Span */
.pure-material-checkbox > span {
    display: inline-block;
    width: 100%;
    cursor: pointer;
}

/* Box */
.pure-material-checkbox > span::before {
    content: "";
    display: inline-block;
    box-sizing: border-box;
    margin: 3px 11px 3px 1px;
    border: solid 2px; /* Safari */
    border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
    border-radius: 2px;
    width: 18px;
    height: 18px;
    vertical-align: top;
    transition: border-color 0.2s, background-color 0.2s;
}

/* Checkmark */
.pure-material-checkbox > span::after {
    content: "";
    display: block;
    position: absolute;
    top: 3px;
    left: 1px;
    width: 10px;
    height: 5px;
    border: solid 2px transparent;
    border-right: none;
    border-top: none;
    transform: translate(3px, 4px) rotate(-45deg);
}

/* Checked, Indeterminate */
.pure-material-checkbox > input:checked,
.pure-material-checkbox > input:indeterminate {
    background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
}

.pure-material-checkbox > input:checked + span::before,
.pure-material-checkbox > input:indeterminate + span::before {
    border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
    background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
}

.pure-material-checkbox > input:checked + span::after,
.pure-material-checkbox > input:indeterminate + span::after {
    border-color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
}

.pure-material-checkbox > input:indeterminate + span::after {
    border-left: none;
    transform: translate(4px, 3px);
}

/* Hover, Focus */
.pure-material-checkbox:hover > input {
    opacity: 0.04;
}

.pure-material-checkbox > input:focus {
    opacity: 0.12;
}

.pure-material-checkbox:hover > input:focus {
    opacity: 0.16;
}

/* Active */
.pure-material-checkbox > input:active {
    opacity: 1;
    transform: scale(0);
    transition: transform 0s, opacity 0s;
}

.pure-material-checkbox > input:active + span::before {
    border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
}

.pure-material-checkbox > input:checked:active + span::before {
    border-color: transparent;
    background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
}

/* Disabled */
.pure-material-checkbox > input:disabled {
    opacity: 0;
}

.pure-material-checkbox > input:disabled + span {
    color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
    cursor: initial;
}

.pure-material-checkbox > input:disabled + span::before {
    border-color: currentColor;
}

.pure-material-checkbox > input:checked:disabled + span::before,
.pure-material-checkbox > input:indeterminate:disabled + span::before {
    border-color: transparent;
    background-color: currentColor;
}


.new-post-m{
  width: 550px;min-height: 450px; height:75vh; max-height: 650px;
  background: #fff;margin: auto;
  -webkit-box-shadow: -2px 6px 30px -13px rgba(0,0,0,0.96);
  -moz-box-shadow: -2px 6px 30px -13px rgba(0,0,0,0.96);
  box-shadow: -2px 6px 30px -13px rgba(0,0,0,0.96);
}

#img-cont{
  width: -webkit-fill-available;height:100vh;background: black;display: flex;
}

#preview_body{
  margin-top: 2em;
}


table.hires{width: 100%}
table.hires td{padding-bottom: 0.4em;width: 50%}
table.hires span.strong{font-weight:600;font-size: 10pt;}
table.hires td.r{text-align: right;padding: 0;vertical-align: initial;padding-top: 7px;}
table.hires tr{border-bottom: 1px solid #ececec;}

div#img-cont:before {
    content: ' ';
    display: inline-block;
    vertical-align: middle;
    height: 100%;
    width: 0;
}

.aside-nav a {
    color: #292929;
    display: flex;
    width: 100%;
}
.employee_search{
  width: 275px;
  margin-top: 15px;
}
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>

<style>

.find-employee{
	text-decoration: none;
    color: #666;
    display: inline-block;
    padding: 20px 10px;
    transition: all 0.5s;
    background: #fff;
    min-width: 180px;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgb(0 0 0 / 12%), 0 1px 2px rgb(0 0 0 / 24%);
}
.find-employee h6{
	margin:0;
}
.find-employee h6, span, a{
  font-size: 10pt;
}
.org-chart {
  display: flex;
  justify-content: center;
}
.org-chart ul {
  padding-left: 0;
  padding-top: 20px;
  position: relative;
  transition: all 0.5s;
}
.org-chart ul ul::before {
  content: "";
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 1px solid #ccc;
  width: 0;
}
.org-chart li {
  float: left;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 10px;
  transition: all 0.5s;
}
.org-chart li::before, .org-chart li::after {
  content: "";
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 1px solid #ccc;
  width: 50%;
  height: 20px;
}
.org-chart li::after {
  right: auto;
  left: 50%;
  border-left: 1px solid #ccc;
}
.org-chart li:only-child::after, .org-chart li:only-child::before {
  display: none;
}
.org-chart li:only-child {
  padding-top: 0;
}
.org-chart li:first-child::before, .org-chart li:last-child::after {
  border: 0 none;
}
.org-chart li:last-child::before {
  border-right: 1px solid #ccc;
  border-radius: 0 5px 0 0;
}
.org-chart li:first-child::after {
  border-radius: 5px 0 0 0;
}
.org-chart li .user {
  text-decoration: none;
  color: #666;
  height: 112px;
  display: inline-block;
  padding: 20px 10px;
  transition: all 0.5s;
  background: #fff;
  min-width: 180px;
  border-radius: 6px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}
.org-chart li .user:hover, .org-chart li .user:hover + ul li .user {
  background: #b5d5ef;
  color: #002A50;
  transition: all 0.15s;
  transform: translateY(-5px);
  box-shadow: inset 0 0 0 3px #76b1e1, 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}
.org-chart li .user:hover img, .org-chart li .user:hover + ul li .user img {
  box-shadow: 0 0 0 5px #4c99d8;
}
.org-chart li .user:hover + ul li::after,
.org-chart li .user:hover + ul li::before,
.org-chart li .user:hover + ul::before,
.org-chart li .user:hover + ul ul::before {
  border-color: #94a0b4;
}
.org-chart li .user > div, .org-chart li .user > a {
  font-size: 12px;
}
.org-chart li .user img {
  margin: 0 auto;
  max-width: 60px;
  max-width: 60px;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  box-shadow: 0 0 0 5px #aaa;
}

.name{
	width: 129px;
    margin: auto;
}
.org-chart li .user{
  font-size: 16px;
  margin: 15px 0 0;
  font-weight: 300;
}
.org-chart li .user .role {
  font-weight: 600;
}
.org-chart li .user .manager {
  font-size: 12px;
  color: #b21e04;
  font-weight: 400;
}
.vl {
     border-left: 1px solid #cccccc;
    height: 135px;
}
#Organization span{
  font-weight: 100;
}
</style>

<div id="view-post-modal" style="display: none;">
  <div id="img-cont">
      <div style="max-width: 1300px;margin:auto;"><img src="" id="preview_image" style="max-width: 100%;max-height: 100vh; margin: auto;"></div>
  </div>
  <div style="width: 600px;height:100vh;background: #fff">
    <span class="closer" onclick="$('#view-post-modal').hide()"></span>
    <div class="preview_content">
      <a class="post-title" id="preview_title"></a>
      <p id="preview_body"></p>
    </div>
  </div>
</div>

<div class="container-fluid" style="padding: 0">

  <div id="navbar" class="navbar-default ace-save-state navbar_hide" >
    <div class="navbar-container ace-save-state" id="navbar-container">
      <div class="bannerContent" style="margin-left: 2em;">
        <div class="nav-blue" style="display: inline-flex;">
          <img src="<?php echo base_url('/assets/login/logo.png')?>" style="width:45px; height:45px;margin-top: 8px">
          <div style="display: grid;width: text-align: left;">
              <span class="topc">Philippine Nuclear Research Institute</span>
              <span class="opc">InfoSys - PNRI Enterprise Information System</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <nav class="portal" style="position: sticky;top: 0;z-index: 9;">
    <ul class="portal">
      <li class="portal"><a href="https://www.pnri.dost.gov.ph/" target="__blank">PNRI Website</a></li>
      <li class="portal"><a href="https://admin.services.pnri.dost.gov.ph/pps/" target="__blank">PPIS</a></li>
      <li class="portal"><a href="http://admin.services.pnri.dost.gov.ph/caat/" target="__blank">CAAT</a></li>
      <li class="portal"><a href="http://dtms.intranet.pnri/" target="__blank">DTMS</a></li>
      <li class="portal"><a href="https://outlook.office.com/mail/inbox" target="__blank">Outlook</a></li>
      <li class="portal"><a href="http://admin.services.pnri.dost.gov.ph/helpdesk/" target="__blank">IT Helpdesk</a></li>
      <!-- <li class="portal"><a href="https://www.pnri.dost.gov.ph/" target="__blank">PNRI Library</a></li> -->

    </ul>
  </nav>

  <div class="col-sm-11 p0" id="af_toggle"></div>

        <main class="main-content" style="width: 100%;display: -webkit-inline-box;margin: 0;padding: 0;background: #e4e3e3;">          <!-- / .main-navbar -->
          <div style="width:350px;border: 1px solid #ececec;background: white;">
            <div style="min-height: 500px;    position: sticky; top: 50px;">
                <div id="loginDiv" style="width: 320px; margin: auto;margin-top: 2.5rem;">
                  <form method="post" id="jvalidate" role="form">
                    <div class="success" id="successmessage" style="display: none">
                        <span style="font-size:12px;display: flex;"><div class="loader"></div> Well done! Now redirecting... </span>
                    </div>
                    <div class="error" id="errormessage" style="display: none">
                        <span style="font-size:12px"> Incorrect Password!</span>
                    </div>
                    <div class="error" id="lockedmessage" style="display: none">
                       <span style="font-size:12px"> Incorrect Username!</b> Please contact the administrator.</span>
                    </div>
                    <div class="warning" id="intrudermessage" style="display: none">
                      <span style="font-size:12px"> <strong>Warning!</strong> You must be logged in to access the Admin side. </span>
                    </div>
                    <div id="message"></div>
                    <div id="slbl"><h5 style="color: #000;text-align: center;margin-bottom: 0;line-height: 25px;">Sign In
                        <br><span style="font-size: 16px;">Login to your InfoSys account</span></h5>
                    </div>
                        <input style="border: 1px #333333 solid;border-radius: 0.25rem; margin: 1em 0;" class="required valid form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" id="username" name="username"/>
                        <input style="border: 1px #333333 solid;border-radius: 0.25rem;" class="required valid form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" id="password" name="password" />
                        <input class="btn btn-red btn-block uppercase" style="border-radius: 3px;margin-top: 1rem;" type="submit" value="Login"/>
                  </form>
                </div>
                <?php $uri = $this->uri->segment(1); ?>
                <ul class="aside-nav">
              <li class="lmenu active" onclick="toggleMenu(this, 'about')"><span class="material-icons">article</span> <span style="margin-left: 1em;">Home</span></li>
              <li class="lmenu" onclick="toggleMenu(this, 'organization')"><span class="material-icons">group</span> <span style="margin-left: 1em;">Staff Directory</span></li>
			  <li class="lmenu"><span class="material-icons">folder</span> <a href="https://pnridostgovph.sharepoint.com/sites/pnri-all/" target="_blank"><span style="margin-left: 1em;">Staff Resources</span></a></li>
              <li class="disabled"><span class="material-icons">book_online</span> <span style="margin-left: 1em;">International Events</span></li>
            </ul>
            </div>
          </div>

          <!-- <div class="main-content-container container-fluid px-4"> -->
            <!-- Page Header -->
            <div id="Organization" style="margin-left: 1em; display:none;">
<div style="display: -webkit-inline-box;">
		<div class="pg-orgchart">
	<div class="org-chart">
		<ul>
      <li>
        <div class="user">
          <!--<img src="https://outlook.office.com/owa/service.svc/s/GetPersonaPhoto?email=caarcilla%40pnri.dost.gov.ph&UA=0&size=HR96x96" class="img-responsive" />-->
          <div class="name">Director</div>
          <div class="role">Carlo A. Arcilla, Ph.D</div>
          <a class="manager" href="#">Director</a>
        </div>
        <ul>
          <li>
            <div class="user">
              <div class="name">Deputy Director</div>
              <div class="role">Lucille V. Abad, Ph.D</div>
              <a class="manager" href="#">Officer-in-Charge, ODD</a>
            </div>

            <ul style="display: flex;margin-left: 31.3rem;width: 100px;">
      			  <div class="vl"></div>
      			  <div class="user" style="margin-left: 2em;">
      				  <div class="name">Planning</div>
      				  <div class="role">Greac M. Carlos</div>
      				  <a class="manager" href="#">Head, PS</a>
      				</div>
      			 </ul>


            <ul style="padding-top:0">
              <li>
                <div class="user">
                  <div class="name">Atomic Research Division</div>
                  <div class="role">Glenda B. Obra</div>
                  <a class="manager" href="#">Officer-in-Charge, ARD</a>
                </div>

      				  <ul>
      				   <div class="user">
      					  <div class="name">Agriculture Research</div>
      					  <div class="role">Glenda B. Obra</div>
      					   <a class="manager" href="#">Head, ARS</a>
      					</div>
      				  </ul>
      				  <ul>
      				   <div class="user">
      					  <div class="name">Biomedical Research</div>
      					  <div class="role">Celia O. Asaad</div>
      					   <a class="manager" href="#">Head, BMRS</a>
      					</div>
      				  </ul>

      				  <ul>
      				   <div class="user">
      					  <div class="name">Health Physics Research</div>
      					  <div class="role">Chitho P. Feliciano, Ph.D.</div>
      					  <a class="manager" href="#">Head, HPRS</a>
      					</div>
      				  </ul>

      				  <ul>
      				   <div class="user">
      					  <div class="name">Applied Physics Research</div>
      					  <div class="role">Neil Raymund D. Guillermo</div>
      					  <a class="manager" href="#">Head, APRS</a>
      					</div>
      				  </ul>

      				  <ul>
      				   <div class="user">
      					  <div class="name">Chemistry Research</div>
      					  <div class="role">Jordan F. Madrid, Ph.D.</div>
      					  <a class="manager" href="#">Head, CRS</a>
      					</div>
      				  </ul>

      				  <ul>
      				   <div class="user">
      					  <div class="name">Nuclear Materials Research</div>
      					  <div class="role">Angel T. Bautista, Ph.D.</div>
      					  <a class="manager" href="#">Head, NMRS</a>
      					</div>
      				  </ul>
              </li>
              <li>
                <div class="user">
                  <div class="name">Nuclear Services Division</div>
                  <div class="role">Preciosa Corazon B. Pabroa, Ph.D.</div>
                  <a class="manager" href="#">NSD Chief</a>
                </div>

				  <ul>
				   <div class="user">
					  <div class="name">Nuclear Reactor Operations</div>
					  <div class="role">Alvie A. Astronomo, Ph.D.</div>
					   <a class="manager" href="#">Head, NROS</a>
					</div>
				  </ul>
				  <ul>
				   <div class="user">
					  <div class="name">Engineering Services</div>
					  <div class="role">Renato T. Bañaga</div>
					   <a class="manager" href="#">Head, ESS</a>
					</div>
				  </ul>

				  <ul>
				   <div class="user">
					  <div class="name">Irradiation Services</div>
					  <div class="role">Haydee M. Solomon</div>
					  <a class="manager" href="#">Head, ISS</a>
					</div>
				  </ul>

				  <ul>
				   <div class="user">
					  <div class="name">Nuclear Analytical Techniques Application</div>
					  <div class="role">Raymond J. Sucgang</div>
					  <a class="manager" href="#">Head, NATAS</a>
					</div>
				  </ul>

				  <ul>
				   <div class="user">
					  <div class="name">Isotope Techniques</div>
					  <div class="role">Adelina D.M. Bulos</div>
					  <a class="manager" href="#">Head, ITS</a>
					</div>
				  </ul>

				  <ul>
				   <div class="user">
					  <div class="name">Radiation Protection Services</div>
					  <div class="role">Kristine Marie D. Romallosa</div>
					  <a class="manager" href="#">Head, RPSS</a>
					</div>
				  </ul>

              </li>
			<li>
                <div class="user">
                  <div class="name">Nuclear Regulatory Division</div>
                  <div class="role">Engr. Alan M. Borras, MPM</div>
                  <a class="manager" href="#">NRD Chief</a>
                </div>

				<ul>
				   <div class="user">
					  <div class="name">Regulation and Standard Development</div>
					  <div class="role">Teresita G. De Jesus</div>
					  <a class="manager" href="#">Head, RSDS</a>
					</div>
				  </ul>
				<ul>
				   <div class="user">
					  <div class="name">Licensing Review and Evaluation</div>
					  <div class="role">Carl M. Nohay</div>
					  <a class="manager" href="#">Head, LRES</a>
					</div>
				  </ul>
				<ul>
				   <div class="user">
					  <div class="name">Inspection and Enforcement</div>
					  <div class="role">Nelson P. Badinas</div>
					  <a class="manager" href="#">Head, IES</a>
					</div>
				  </ul>

				<ul>
				   <div class="user">
					  <div class="name">Nuclear Safeguards and Security</div>
					  <div class="role">Maria Teresa A. Salabit</div>
					  <a class="manager" href="#">Head, NSSS</a>
					</div>
				  </ul>

				<ul>
				   <div class="user">
					  <div class="name">Radiological Impact Assessmenet</div>
					  <div class="role">Cecilia M. De Vera</div>
					  <a class="manager" href="#">Head, RIAS</a>
					</div>
				  </ul>


             </li>
			<li>
                <div class="user">
                  <div class="name">Techonolgy Diffusion Division</div>
                  <div class="role">Ana Elena L. Conjares, M.Sc.</div>
                  <a class="manager" href="#">TDD Chief</a>
                </div>

				<ul>
				   <div class="user">
					  <div class="name">International Cooperation</div>
					  <div class="role">Faye G. Rivera</div>
					  <a class="manager" href="#">Head, ICS</a>
					</div>
				  </ul>

				<ul>
				   <div class="user">
					  <div class="name">Nuclear Training Center</div>
					  <div class="role">Roel A. Loteriña</div>
					  <a class="manager" href="#">Head, NTC</a>
					</div>
				  </ul>

				<ul>
				   <div class="user">
					  <div class="name">Nuclear Information and Documentation</div>
					  <div class="role">Framelia A. Anonas</div>
					  <a class="manager" href="#">Head, NIDS</a>
					</div>
				  </ul>

				<ul>
				   <div class="user">
					  <div class="name">Business Development</div>
					  <div class="role">Pinzon, Ronald Alan S.</div>
					  <a class="manager" href="#">Head, BDS</a>
					</div>
				  </ul>
				<ul>
				   <div class="user">
					  <div class="name">Management Information Systems Section</div>
					  <div class="role">Christopher G. Halnin</div>
					  <a class="manager" href="#">Head, MISS</a>
					</div>
				  </ul>

             </li>
			<li>
                <div class="user">
                  <div class="name">Finance and Administrative Division</div>
                  <div class="role">Maria Celerina M. Ramiro</div>
                  <a class="manager" href="#">FAD CHIEF</a>
                </div>

				<ul>
				   <div class="user">
					  <div class="name">Budget</div>
					  <div class="role">Bernard M. De lara</div>
					  <a class="manager" href="#">Head, BS</a>
					</div>
				  </ul>
				<ul>
				   <div class="user">
					  <div class="name">Accounting</div>
					  <div class="role">Gerald DG. Conise</div>
					  <a class="manager" href="#">Head, AS</a>
					</div>
				  </ul>
				<ul>
				   <div class="user">
					  <div class="name">Cash</div>
					  <div class="role">Susan S. Pascual</div>
					  <a class="manager" href="#">Head, CS</a>
					</div>
				  </ul>

				<ul>
				   <div class="user">
					  <div class="name">Property and Procurment</div>
					  <div class="role">Hidie S. Gocuyo</div>
					  <a class="manager" href="#">Head, PPS</a>
					</div>
				  </ul>
				<ul>
				   <div class="user">
					  <div class="name">Human Resources</div>
					  <div class="role">Ma. Nadia D.C. Estaris</div>
					  <a class="manager" href="#">Head, HRMCS</a>
					</div>
				  </ul>
      </li>
        </ul>
      </li>
    </ul>
            </div>
          </div>
          <div class="employee_search">
            <div class="row">
              <input type="text" class="form-control" style="width:275px; border-radius:4px;" placeholder="Search not implemented yet.">
              <span style="margin-top:0.3em; margin-left:5px">You must be logged in to search to search directory.</span>
            </div>
            <br>
              <div class="find-employee" style="width: 275px;margin:auto;margin-left: -14px;margin-top: -14px;">
              <h6>_name <span style="float:right;color: #969696;">_sec - _div</span></h6>
              <a href="#">_email</a>

              <div style="margin-top: 1em;">
                <h6>Trainings:</h6>
                  <span>Nothing to show.</span>
              </div>

              <div style="margin-top: 1em;">
                <h6>Recognitions:</h6>
                <span>Nothing to show.</span>
              </div>

              <div style="margin-top: 1em;">
                <h6>Publications:</h6>
                  <span>Nothing to show.</span>
              </div>

              <div style="margin-top: 1em;">
                <h6>Membership in Association/Organization:</h6>
                <span>Nothing to show.</span>
              </div>
            </div>
          </div>
        </div>
        </div>
              <div id="About" style="margin: auto">
                  <div class="row" id="article_board" style="width: 600px;margin:auto;">
                    <?php
                    foreach ($posts as $p) {
                      $a ='';
                      if($p->attachments != null){
                        $a = '<div onclick="view_image('.$p->id.')" class="post-img" style="background:url(https://admin.services.pnri.dost.gov.ph/intranet/uploads/images/'.$p->attachments['file_name'].');background-repeat: no-repeat;background-size: cover;background-position: center; width:520px;"></div>';
                      }
                      #by <b>'.$p->emp.'</b>

                      echo '<div class="announcement d-flex p-4" >
                        <div class="article-content blog-comments__content">
                          <div class="blog-comments__meta text-muted">
                            <a href="#" class="post-title">'.$p->post_title.'</a>
                            <span class="announce_date">published on <b>'. $p->post_date.'</b>  by <span>'.$p->emp.'</span></span>
                          </div>
                          <div class="article-min post-textbody" onclick="toggleExpand(this)">
                            <p class="m-0 my-1 mb-2" align="justify">'. str_replace("\n","<br>",$p->post_text) . ($p->lchar + (86*$p->newlines) > 946?'<a href="#" class="expand">Read More...</a>':'').'</p>
                          </div>'.$a.'
                        </div>

                      </div>';
                    }
                    ?>
                </div>
              </div>

              <div id="announcement_div">
                <h6 class="text-center" style="background: #e2edf3;font-size: 15pt;font-weight: 500;padding: 0.35em;margin: 0;">ANNOUNCEMENTS <span class="material-icons">campaign</span></h6>
                <div id="post_board" style="max-height: 900px;overflow-y: scroll;">
                <?php
                  foreach ($announcements as $an) {
                    $pinned = '';
                    if($an->pinned == '1'){
                      $pinned = '<div class="blog-comments__meta tr" style="float:right"> <i class="material-icons">lock</i></div>';
                    }
                    echo '<div class="announcement d-flex p-3">
                      <div class="blog-comments__content">' .$pinned.'
                        <div class="blog-comments__meta text-muted">
                          <a href="#" style="font-size: 16pt;    color: #e7505a;">'. $an->title.'</a>
                          <span class="announce_date">posted on '. $an->date_create.'</span>
                        </div>
                        <p class="m-0 my-1 mb-2">'.  str_replace("\n","<br>",$an->body).'</p>
                      </div>
                    </div>';
                  }
                ?>
                </div>
            </div>

       <!--  </div> -->
  </main>
  <!-- FOOTER -->
        <section class="pb_section bg-light" style="background-image: linear-gradient(white, rgba(255, 255, 255, 0.67)),url(<?php echo base_url('/assets/login/reactor2.jpg')?>);background-size: cover;background-position-x: center;min-height: 500px;padding: 3rem;    border-top: 1px solid #f3f3f3cc;">
          <div class="row">
            <div class="col-md-5">

              <div class="col-md-12">
                <b>About Us</b>
                <p align="justify">The Philippine Nuclear Research Institute (PNRI), formerly the Philippine Atomic Energy Commission, has been the center of nuclear science and technology activities in the country since 1958. The PNRI is mandated to undertake research and development activities in the peaceful uses of nuclear energy, to institute regulations on the said uses and to carry out the enforcement of said regulations to protect the health and safety of radiation workers and the general public.</p>
              </div>

              <div class="col-md-12">
                <b>Vision</b>
                <p align="justify">The PNRI is an institution of excellence – a provider of innovative and effective nuclear and radiation science and technology for national prosperity.</p>
              </div>

              <div class="col-md-12">
                <b>Mission</b>
                <p align="justify">We contribute to the improvement of the quality of Filipino life through the highest standards of research and development, specialized nuclear and radiation services, technology transfer, and efficient implementation of nuclear and radiation safety practices and regulations.</p>
              </div>

            </div>

            <div class="row col-md-7">
              <div class="col-md-5">
               <b>SERVICES PORTAL</b>
               <br>
               <p><a href="https://services.pnri.dost.gov.ph/portal/Irradiation" target="__blank"><b>Irradiation Services</b></a></p>
               <p><a href="https://services.pnri.dost.gov.ph/portal/natas/welcome" target="__blank"><b>Nuclear Analytical Services</b></a></p>
               <p><a href="https://services.pnri.dost.gov.ph/portal/nrd/Appoint" target="__blank"><b>Nuclear Regulatory Services</b></a></p>
               <p><a href="http://https://services.pnri.dost.gov.ph/portal/" target="__blank"><b>Nuclear Training Courses</b></a></p>
               <p><a href="https://services.pnri.dost.gov.ph/portal/Appoint" target="__blank"><b>Radiation Protection Services</b></a></p>
               <p><a href="https://services.pnri.dost.gov.ph/portal/other" target="__blank"><b>Other Services</b></a></p>

                </div>
              <div class="col-md-5">
               <b>INTRANET</b>
               <br>
               <p><a href="http://main.intranet.pnri/workshops-and-events/" target="__blank"><b>International Events</b></a></p>
               <p><a href="http://main.intranet.pnri/resources/" target="__blank"><b>Staff Resources</b></a></p>
               <p><a href="http://main.intranet.pnri/organizational-chart/" target="__blank"><b>Staff Directory</b></a></p>
               <p><a href="http://main.intranet.pnri/knowledge-base/" target="__blank"><b>Knowledge Base</b></a></p>
                </div>
              </div>
          </div>

          <span style="float:right"> Copyright © 2020 - Philippine Nuclear Research Institute. All rights reserved.</span>


        </section>

  <!-- Return to Top -->
<script type="text/javascript">
base_url = '<?php echo base_url()?>';

function toggleMenu(ele, a){
  $('.lmenu').removeClass('active');
  $(ele).addClass('active');
  switch (a) {
    case 'organization':
      $('#Organization').show();
      $('#About, #announcement_div').hide();
      break;
    case 'about':
      $('#Organization').hide();
      $('#About, #announcement_div').show();
      break;
  }
}
$(document).ready(function () {
  $('#username').focus();
  $("#jvalidate").on('submit',(function(e) {
    $('#slbl').hide();
    $('#errormessage').hide();
    $('#successmessage').hide();
    $('#intrudermessage').hide();
    $('#lockedmessage').hide();
    e.preventDefault();
    if($("#jvalidate").valid())
    {
      var formdata = $("#jvalidate").serialize();
          $('#message').append("<div id='message2'></div>");
          $('#message2').html('<span style="display: flex; font-size:11px;"><div class="loader"></div> Checking.. Please wait... </span>');
          setTimeout(function(){
        $.ajax({
          url: "<?php echo site_url('access/login'); ?>",
          type: "POST",
          async: true,
          data: formdata,
          dataType: 'json',
          cache: false,
          success: function(data){
            if (data[0] == 0){
              $('#errormessage').show();
            }else if (data[0] == 1){
              $('#successmessage').show();
              $('#errormessage').hide();
              setTimeout(function(){
                /*if(data[1] == 6)
                  if("<?php echo $_SERVER['REMOTE_ADDR'];?>" == "10.127.34.1")
                    window.location.replace("<?php echo base_url('loans');?>")
                  else
                    window.location.replace("<?php echo base_url('access/extra403');?>")
                else*/
                  <?php
                  if($this->input->get('t') == 'iss'){
                    echo 'window.location.replace("https://admin.services.pnri.dost.gov.ph/iss/");';
                  }
                  else if($this->input->get('t') == 'pps'){
                    echo 'window.location.replace("https://admin.services.pnri.dost.gov.ph/pps/");';
                  }
                  else if($this->input->get('t') == 'helpdesk'){
                            echo 'window.location.replace("https://admin.services.pnri.dost.gov.ph/helpdesk/");';
                          }
                  else if($this->input->get('t') == 'intranet'){
                              echo 'window.location.replace("https://admin.services.pnri.dost.gov.ph/intranet/");';
                          }
                  else if($this->input->get('t') == 'consult'){
                            echo 'window.location.replace("https://admin.services.pnri.dost.gov.ph/intranet/Consultation");';
                          }
                  else if($this->input->get('t') == 'caat'){
                            echo 'window.location.replace("https://admin.services.pnri.dost.gov.ph/caat/");';
                          }
                  else{
                    echo 'window.location.replace("' .base_url('dashboard') .'");';
                  }
                  ?>
              },600);
            }else if (data==2){
              $('#lockedmessage').show();
            }else{}
          },
          error: function(data)
          {
              $('#errormessage').show();
          }
        });
        $('#message2').empty();

      },600)
    }
  }));
})



/*COMMON W/ INTRANET*/
document.addEventListener('keydown', function(event){
  if(event.key === "Escape"){
    $('#view-post-modal').hide();
  }
});

function view_image(id){
  $('#view-post-modal').show();

  $.ajax({
    url: "<?php echo site_url('Intranet/getPost'); ?>",
    type: "POST",
    async: true,
    data: {id:id},
    dataType: 'json',
    cache: false,
    success: function(d){
      $('#preview_title').text(d.post_title);
      $('#preview_body').html(d.post_text);
      $('#preview_image').attr('src', 'https://admin.services.pnri.dost.gov.ph/intranet/uploads/images/'+ d.post_attachments.file_name);
    }
  });
}

function toggleExpand(ele){
  $(ele).toggleClass('article-min');
  $(ele).find('.expand').toggle();
}
</script>
