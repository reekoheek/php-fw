Object.extend(Position, {
	getPageSize: function(){	
		var xScroll, yScroll;	
		if (window.innerHeight && window.scrollMaxY) {	
			xScroll = window.innerWidth + window.scrollMaxX;
			yScroll = window.innerHeight + window.scrollMaxY;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			xScroll = document.body.scrollWidth;
			yScroll = document.body.scrollHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
			yScroll = document.body.offsetHeight;
		}	
		var windowWidth, windowHeight;
		if (self.innerHeight) {	// all except Explorer
			if(document.documentElement.clientWidth){
				windowWidth = document.documentElement.clientWidth; 
			} else {
				windowWidth = self.innerWidth;
			}
			windowHeight = self.innerHeight;
		} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if (document.body) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		}
		if(yScroll < windowHeight){
			pageHeight = windowHeight;
		} else { 
			pageHeight = yScroll;
		}
		if(xScroll < windowWidth){	
			pageWidth = xScroll;		
		} else {
			pageWidth = windowWidth;
		}
		arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
		return arrayPageSize;
	},
	
	centerize: function(el) {
		var parentWidth = 0;
		var parentHeight = 0;
		if (el.style.position == "absolute") {
			var pageSize = this.getPageSize();
			parentWidth = pageSize[2];
			parentHeight = pageSize[3];
		} else {
			parentWidth = Element.getWidth(el.parentNode);
			parentHeight = Element.getHeight(el.parentNode);
		}
		el.style.left = (parentWidth - el.getWidth()) / 2 + 'px'; 
		el.style.top = (parentHeight - el.getHeight()) / 2 + 'px';
	}
});