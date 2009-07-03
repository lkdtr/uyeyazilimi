var global = window.document
var MENU_BORDER_COLOR = '#999999'
var MENU_CURRENTPAGE_COLOR = '#ffffff'
var MENU_MOUSEOVER_COLOR = '#cccccc'
var MENU_MOUSEDOWN_COLOR = '#999999'

function normalized_href(href)
{
	href = href.toLowerCase();
	var slash = href.lastIndexOf("/");
	if (-1 != slash) 
	{
		var filename = href.substr(slash + 1);
		if ("default.htm" == filename || "default.asp" == filename)
			href = href.substr(0, slash + 1);
	}
	return href;
}

function event_onload()
{
	if (!global.all) return
	
	var items = global.all.tags("TD")
	var i	
	var lhref = normalized_href(location.href)

	for (i=0; i<items.length; i++)
	{
		var item = items[i]
		if (item.className == "flyoutLink")
		{
			var disabled = false
			var anchors = item.all.tags("A")			
			if (anchors.length > 0)
			{
				var anchor = anchors.item(0)
				var ahref = normalized_href(anchor.href)				
				if (ahref == lhref)
				{
					anchor.outerHTML = anchor.innerHTML
					item.style.borderColor = MENU_BORDER_COLOR
					item.style.backgroundColor = MENU_CURRENTPAGE_COLOR
					item.style.cursor = 'default'
					disabled = true					
				}				
			}
			item.defaultBorder = item.style.borderColor
			item.defaultBackground = item.style.backgroundColor
			item.attachEvent("onmouseover", item_onmouseover)
			item.attachEvent("onmouseout", item_onmouseout)
			if (!disabled)
			{
				item.attachEvent("onmousedown", item_onmousedown)
				item.attachEvent("onmouseup", item_onmouseup)
			}			
		}
	}	
}



function item_onmouseover()
{	
	var e = whichItem()
	if (e.contains(window.event.fromElement))
		return
	if (e.style.backgroundColor != MENU_CURRENTPAGE_COLOR)
	{		
		e.style.borderColor = MENU_BORDER_COLOR
		e.style.backgroundColor = MENU_MOUSEOVER_COLOR
	}	
	var a = e.all.tags("A")
	if (a.length > 0)
		window.status = a[0].href
}

function item_onmouseout()
{	
	var e = whichItem()
	var te = window.event.toElement
	if (te)
		if (e.contains(te))
			return
	e.style.borderColor = e.defaultBorder
	e.style.backgroundColor = e.defaultBackground	
	window.status = ""
}

function whichItem()
{
	var e = event.srcElement
	while (e.tagName != "TD")
		e = e.parentElement
	return e
}

function item_onmousedown()
{	
	if ((event.button & 1) == 0)
		return;
	var e = whichItem()
	e.style.backgroundColor = MENU_MOUSEDOWN_COLOR
	e.mouseIsDown = 1
}

function item_onmouseup()
{	
	if ((event.button & 1) == 0)
		return;
	var e = whichItem()
	if (e.mouseIsDown != 1)
		return
	e.mouseIsDown = false
	e.style.backgroundColor = MENU_MOUSEOVER_COLOR
	var a = e.all.tags("A")
	if (a.length > 0)
		location.href = a[0].href
}
