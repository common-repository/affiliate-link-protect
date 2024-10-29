  	 var hrefs = [];
	 var alpid = 0;   
     jQuery(document).ready(function () {
	    if(alp_param>"") {var to_find = 'a[href*="'+alp_param+'=1"]';}
        else {var to_find = 'a[href]';}	    
	    jQuery(document).find(to_find).each(function() {
           hrefs.push(this.href);   // save link
		   jQuery(this).data('xuwkh_alp_id',alpid);    // set link id
	 	   alpid ++;   
		   
		   // cut parts from url
		   if(typeof alp_elimi_paras[0]=== 'undefined') {
		   this.href = this.href.split('?')[0];
		   
		   }
		   else {
	          this.href = this.href.replace(new RegExp('[?&]' + alp_param + '=[^&#]*(#.*)?$'), '$1').replace(new RegExp('([?&])' + alp_param + '=[^&]*&'), '$1');
			  for (var y = 0; y < alp_elimi_paras.length; ++y) {
		      	 this.href = this.href.replace(new RegExp('[?&]' + alp_elimi_paras[y] + '=[^&#]*(#.*)?$'), '$1').replace(new RegExp('([?&])' + alp_elimi_paras[y] + '=[^&]*&'), '$1');
				 };
			  }	 
		   });

		jQuery('a').click(function(e) {
           if(hrefs[jQuery(this).data("xuwkh_alp_id")]!=null)
		      {
			  var url = hrefs[jQuery(this).data("xuwkh_alp_id")].replace("?"+alp_param+"=1", "").replace("&"+alp_param+"=1", "");
		   	  e.preventDefault();
			  if(jQuery(this).attr("target")!=null)
			     {
				 window.open(url,jQuery(this).attr("target"));
				 }
			  else
			     {	 
		   	  	 window.location.href = url;
				 }
			  }
		   });
	    });
