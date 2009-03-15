<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">
<head>
	<title>LKD</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

	<style type="text/css" media="screen">@import "css/reset.css";</style>
	<style type="text/css" media="screen">@import "css/screen.css";</style>
	<style type="text/css" media="screen">
		p{
			padding:5px;
		}
	</style>
	<script type="text/javascript" src="js/jquery-1.2.6.pack.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$("form").submit(function(){

				var uyeno = $("#"+$(this).attr("id")+" input:text").val();

				if(uyeno == ""){
					alert("Üye no. boş bırakılamaz!");
					return false;
				}

				//alert($("#dugme input:hidden"));

			
				$(this).parents('.mright').prev().html('');
				$("input:hidden").each(function(i, n){		
					$(this).parents('.mright').prev().append("<p><img src=\"yaz.php?tur=&secim="+i+"&uyeno="+uyeno+"\" /></p>");
					//alert(i+"---"+n);
				});
				

				$("#"+$(this).attr("id")+" input:submit").removeAttr("disabled");
				
				return false;
				
			});

		});
	
	</script>
	
	
<body>

<div id="wrapper">
	<div id="header"><img src="img/lkd-header.jpg" width="860" height="100" alt="Lkd Header"></div>
	<div class="mleft">
		<p><img src="img/lkd-00.png"></p>
		<p><img src="img/lkd-01.png"></p>
		<p><img src="img/lkd-02.png"></p>
		<p><img src="img/lkd-03.png"></p>
		<p><img src="img/lkd-04.png"></p>				
	</div>
	<div class="mright">
		<form id="dugme" method="post" aciton="yaz.php?tur=dugme">
		<fieldset>
		<ol>

		 	<li>
		 		<input type="hidden" id="s1" name="sablon" value="0">
		 		<input type="hidden" id="s2" name="sablon" value="1">
		 		<input type="hidden" id="s3" name="sablon" value="2">
		 		<input type="hidden" id="s4" name="sablon" value="3">
		 		<input type="hidden" id="s5" name="sablon" value="4">
		 	</li>
			<li>
				<label for="uyeno">Üye no.</label><input class="mod" type="text" name="uyeno" id="uyeno" />
			</li>		
		</ol>
		<p><input class="btn" type="submit" value="Oluştur"></p>
		</fieldset>
		</form>
	</div>
	<div class="clear"></div>
	
	<div class="clear"></div>	
	<div id="footer">LKD 2009</div>
</div>
