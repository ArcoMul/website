var url = window.location.pathname.replace("/page/","").replace("/","");
if(/^\d*$/.test(url) && url != "")  
{
	window.location.href = "/#/page/" + url;
}

// DOM objects
var middle = {};
// var right = {};
var left = {};
var arrow = {};

/**
 * Two object to take care of loading posts and tweets
 */
var feed = {
	lastId: 0
};
var posts = {
	page: 1
};

var pages = {
	"/": "blog"
}
var page = typeof pages[window.location.pathname] != 'undefined' ? pages[window.location.pathname] : "";

var touch = {
	start: {}
}
/**
 * The load animation object, used to create load animations
 */
var LoadAnimation = function(elm) {
	
	this.elm = elm;
	
	this.init = function()
	{
		this.elm.css("position","relative");
		this.elm.width(60).height(60);
		for(var i = 1; i < 10; i++)
			this.elm.append("<div class='"+(i == 5 ? "hide" : "frame")+"' style='background-color:#fff;width:20px;height:20px;float:left;'>");
		this.elm.append("<div class='overlay' style='position:absolute;left:0;top:0;width:60px;height:60px;'>");
		this.frames = {
			0: this.elm.children('.frame').eq(0),
			1: this.elm.children('.frame').eq(1),
			2: this.elm.children('.frame').eq(2),
			3: this.elm.children('.frame').eq(4),
			4: this.elm.children('.frame').eq(7),
			5: this.elm.children('.frame').eq(6),
			6: this.elm.children('.frame').eq(5),
			7: this.elm.children('.frame').eq(3),
		}
		
		this.elm.children(".hide").css("opacity", 0);
		var opacity = 1;
		
		for(index in this.frames)
		{
			this.frames[index].css("opacity", opacity);
			opacity -= 0.125;
		}
	}
	this.animate = function()
	{
		for(index in this.frames)
		{
			if(index == 7)
				opacity = this.frames[0].css("opacity");
			else
				opacity = this.frames[parseInt(index)+1].css("opacity");
			
			this.frames[index].css("opacity", opacity);
		}
		
	}
	this.init();
}

var scrollToTop = function(e)
{
	e.preventDefault();
	jQuery.scrollTo({ top:0 }, 1000, {axis:'y'});
}

var url = {
	// Uitgaande links openen in een nieuw tabblad
	fix: function(){
	   	var pathname = window.location.host;
		$("a[href^='http://'], a[href^='http://www.'], a[href^='www.'], a[rel='external']").not("a[href^='http://" + pathname + "'], a[href^='http://" + pathname.replace('www.','') + "']").attr('target','_blank');
	}
}

$(document).ready(function(){
	
	url.fix();
	
	// Touch and scroll stuff
	window.addEventListener('scroll', scroll, false);
	window.addEventListener('DOMMouseScroll', scroll, false);
	window.onmousewheel = document.onmousewheel = document.onscroll = document.documentElement.onscroll = window.onscroll = scroll;
	
	middle.elm = $(".column.middle");
	// right.elm = $(".column.right");
	left.elm = $(".column.left");
	arrow.elm = $("#goToTop");
	
	// Clicking on the 'back to top' arrow scrolls the user to the top
	arrow.elm.click(scrollToTop);
	$(".current-menu-item").click(scrollToTop);
	
	$('.button-name').click(function(){
		if($(this).hasClass('collapsed'))
			$(this).removeClass('collapsed').children('.content').slideUp();
		else
			$(this).addClass('collapsed').children('.content').slideDown();
	});
	$('.button-name .content').click(function(e){
		e.stopPropagation();
	});

    $(".top-menu-button").click(function (e) {
        if ($(".menu-main-container").is(":visible")) {
            $(".menu-main-container").hide();
        } else {
            $(".menu-main-container").show();
        }
    });
	
	// Setup the load animations
	//right.loadAnimation = new LoadAnimation($(".right .load-animation"));
	middle.loadAnimation = new LoadAnimation($(".middle .load-animation"));
	setInterval(animate, 150);
	
	// When there is set a hash, remove the item holder and load the page according to the hash
	if(window.location.hash.replace("#/page/") != "")
	{
		$(".item-holder").remove();
		posts.page = parseInt(window.location.hash.replace("#/page/","")) - 1;
		getPosts();
	}
	
	// Move the main feed upwards, so it look likes it flying in
	$(".item-holder").css("margin-top", $(window).height()).animate({
		marginTop: 0
	}, 500);
	
	reinitializeShapes();
	
	// getFeed();
	
	windowResize();
});

$(window).load(function(){
	reinitializeShapes();
	windowResize();	
});
	
$(window).resize(function(){
	windowResize();	
});

// When resizing the window all elements should be recalculated and repositioned
function windowResize()
{
	windowWidth = $(window).width() - ($(window).width() % 10);
	if(windowWidth > 850)
		windowWidth = 850;
	
	// Width percentages for the columns
	var pLeft, pMiddle, pRight;
	
	if($(window).width() > 730) {
		pLeft = 0.20;
		pMiddle = 0.80;
		// pRight = 0.25;
		windowWidth -= 60;
	} else {
		pLeft = 0;
		pMiddle = 1;
		// pRight = 0;
		windowWidth -= 60;
	}
	
	/**
	 * Calculate the width and left position of the columns
	 */
	
	left.width = Math.floor(windowWidth * pLeft);
	left.width = left.width - (left.width % 10);
    if (left.width == 0) {
        $("body").addClass("top-menu")
    } else {
        $(".menu-main-container").show();
        $("body").removeClass("top-menu")
    }
	
	middle.width = Math.floor(windowWidth * pMiddle);
	middle.width = middle.width - (middle.width % 10);
	
	// right.width = Math.floor(windowWidth * pRight);
	// right.width = right.width - (right.width % 10);
	
	left.elm.width(left.width);
	left.elm.height($(window).height());
	
	arrow.left = (left.width - arrow.elm.width()) / 2;
	arrow.left = arrow.left  - (arrow.left  % 10);
	arrow.elm.css('left', arrow.left);
	
	middle.left = left.width + 30;
	middle.elm.css('left', middle.left).width(middle.width);
	
	// right.left = middle.left + middle.width + 30;
	// right.elm.css('left', right.left).width(right.width);

	middle.loadAnimation.elm.css("margin-left", Math.round(((middle.width - middle.loadAnimation.elm.width()) / 2) / 10) * 10);
	// right.loadAnimation.elm.css("margin-left", Math.round(((right.width - right.loadAnimation.elm.width()) / 2) / 10) * 10);
	
	/**
	 * End: calculate
	 */
}

/**
 * Scrolls the page down, as scrolls the background
 * @param {Object} e
 * @param {Object} to
 */
function scroll(event, to) {
	
	// Show the arrow 'back to top' when leaving top of page
	if(arrow.elm.is(':visible') && $(window).scrollTop() < 40)
		arrow.elm.fadeOut();
	else if (!arrow.elm.is(':visible') && $(window).scrollTop() > 40 && $(window).width() > 450 && !$("body").hasClass("top-menu"))
		arrow.elm.fadeIn();
	
	// if($(window).scrollTop() > right.elm.height() - ($(window).height() * 0.75))
    // getFeed();
	
	if(page === "blog")
	{
		// Define what real page you are looking at
		var pageNumber;
		middle.elm.children(".item-holder").each(function(){
			if($(this).offset().top + $(this).height() > $(window).scrollTop() + ($(window).height() * 0.25) && $(this).offset().top < $(window).scrollTop() + ($(window).height() * 0.25))
				pageNumber = $(this).data("page");
		});
		if(typeof pageNumber == 'undefined')
		{
			pageNumber = middle.elm.children(".item-holder:last").data("page");
		}
		window.location.hash = "/page/" + pageNumber;
		
		if($(window).scrollTop() > middle.elm.height() - ($(window).height() * 0.75))
			getPosts();
	}
	
}

// Will be called every 150 miliseconds
function animate()
{
	middle.loadAnimation.animate();
	// right.loadAnimation.animate();
}

function getPosts()
{
	if(posts.call == undefined || posts.call.readyState == 4)
	{
		posts.page++;
		posts.call = $.ajax({
			url: '/',
			data: {
				page: posts.page,
				ajax: true
			},
			beforeSend: function()
			{
				// Show the load animation
				middle.loadAnimation.elm.fadeIn(400);
			},
			success: function (data)
			{
				// Create a ul element with a margin as height as the height of the screen
				middle.elm.append("<div class='item-holder'>");
				var div = middle.elm.children(".item-holder:last-child");
				div.css("margin-top", $(window).height()).data("page", posts.page);
				div.append(data);
				
				url.fix();
				
				$(".nextpage").fadeOut(200, function(){
					$('.nextpage').last().show();
				});
				$(".nextpage").css("margin-left", Math.round(((middle.width - $(".nextpage").width()) / 2) / 10) * 10);
				
				// Animate the new tweets to the others
				div.animate({
					marginTop: 0
				}, 500);
				
				// Fade out the load-animation, just some faster as the new tweets animate to the top
				middle.loadAnimation.elm.fadeOut(200, function(){
					middle.elm.append(middle.loadAnimation.elm);
				});
				
				middle.elm.waitForImages(function() {
		             reinitializeShapes();
		        });
			},
			error: function()
			{
				posts.page--;
			}
		});
	}
}

function getFeed()
{
	if(feed.call == undefined || feed.call.readyState == 4)
	{
		feed.call = $.ajax({
			url: '/wp-content/themes/pixels/ajax.php',
			data: {
				count: 5,
				lastid: feed.lastId
			},
			beforeSend: function()
			{
				// Show the load animation
				right.loadAnimation.elm.fadeIn(400);
			},
			success: function (data)
			{
				// Create a ul element with a margin as height as the height of the screen
				right.elm.append("<ul>");
				var ul = right.elm.children("ul:last-child");
				ul.css("margin-top", $(window).height());
				ul.append(data);
				
				url.fix();
				
				// Animate the new tweets to the others
				ul.animate({
					marginTop: 0
				}, 500);
				
				// Fade out the load-animation, just some faster as the new tweets animate to the top
				right.loadAnimation.elm.fadeOut(200, function(){
					right.elm.append(right.loadAnimation.elm);
				});
				
				feed.lastId = right.elm.children(":last").children(":last").data("id").replace("id", "");
				
				reinitializeShapes();
			}
		});
	}
}

/**
 * Adding classes to links and padding to images
 */
function reinitializeShapes()
{
	// Give links an extra padding to the right when their with is not devidable by 10
	$("p a, ul li a, h2 a, .header a").each(function(){
		if($(this).children("img").length === 0 && !$(this).hasClass("text-link"))
			$(this).addClass("text-link").css("padding-right", 10 - ($(this).width() % 10));
	});
	$(".middle .item img").each(function(){
		$(this).css("padding-bottom", $(this).height() % 10 != 0 ? 10 - ($(this).height() % 10) : 0);
	});
	$(".nextpage").css("margin-left", Math.round(((middle.width - $(".nextpage").width()) / 2) / 10) * 10);
}
