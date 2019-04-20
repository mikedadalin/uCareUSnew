;(function($){
/**
 * jqGrid Chinese (Taiwan) Translation for v4.2
 * linquize
 * https://github.com/linquize/jqGrid
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 * 
**/
$.jgrid = $.jgrid || {};
$.extend($.jgrid,{
	defaults : {
		recordtext: "{0} - {1} totally {2} items",
		emptyrecords: "No record",
		loadtext: "loading...",
		pgtext : " {0} totally {1} page(s)"
	},
	search : {
		caption: "Search...",
		Find: "Search",
		Reset: "Reset",
		odata: [{ oper:'eq', text:"等於 "},{ oper:'ne', text:"不等於 "},{ oper:'lt', text:"小於 "},{ oper:'le', text:"小於等於 "},{ oper:'gt', text:"大於 "},{ oper:'ge', text:"大於等於 "},{ oper:'bw', text:"開始於 "},{ oper:'bn', text:"不開始於 "},{ oper:'in', text:"在其中 "},{ oper:'ni', text:"不在其中 "},{ oper:'ew', text:"結束於 "},{ oper:'en', text:"不結束於 "},{ oper:'cn', text:"包含 "},{ oper:'nc', text:"不包含 "},{ oper:'nu', text:'is null'},{ oper:'nn', text:'is not null'}],
		groupOps: [	{ op: "AND", text: "所有" },	{ op: "OR",  text: "任一" }	],
		operandTitle : "Click to select search operation.",
		resetTitle : "Reset Search Value"
	},
	edit : {
		addCaption: "New record",
		editCaption: "Edit record",
		bSubmit: "Submit",
		bCancel: "Cancel",
		bClose: "Close",
		saveData: "Data been changed, do you want to save changes?",
		bYes : "Yes",
		bNo : "No",
		bExit : "Cancel",
		msg: {
			required:"This field is required",
			number:"Plese input valid number",
			minValue:"Value must be at least ",
			maxValue:"Value must be at most ",
			email: "Not a valid e-mail address",
			integer: "請輸入有效整数",
			date: "請輸入有效時間",
			url: "網址無效。前綴必須為 ('http://' 或 'https://')",
			nodefined : " 未定義！",
			novalue : " 需要傳回值！",
			customarray : "自訂函數應傳回陣列！",
			customfcheck : "自訂檢查應有自訂函數！"
			
		}
	},
	view : {
		caption: "查看記錄",
		bClose: "關閉"
	},
	del : {
		caption: "Delete",
		msg: "Delete selected record?",
		bSubmit: "Delete",
		bCancel: "Cancel"
	},
	nav : {
		edittext: "",
		edittitle: "編輯已選列",
		addtext:"",
		addtitle: "新增列",
		deltext: "",
		deltitle: "刪除已選列",
		searchtext: "",
		searchtitle: "搜尋記錄",
		refreshtext: "",
		refreshtitle: "重新整理表格",
		alertcap: "警告",
		alerttext: "請選擇列",
		viewtext: "",
		viewtitle: "檢視已選列"
	},
	col : {
		caption: "選擇欄",
		bSubmit: "確定",
		bCancel: "Cancel"
	},
	errors : {
		errcap : "錯誤",
		nourl : "未設定URL",
		norecords: "無需要處理的記錄",
		model : "colNames 和 colModel 長度不同！"
	},
	formatter : {
		integer : {thousandsSeparator: " ", defaultValue: '0'},
		number : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, defaultValue: '0.00'},
		currency : {decimalSeparator:".", thousandsSeparator: " ", decimalPlaces: 2, prefix: "", suffix:"", defaultValue: '0.00'},
		date : {
			dayNames:   [
				"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		         "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"
			],
			monthNames: [
				"Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec",
				"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
			],
			AmPm : ["上午","下午","上午","下午"],
			S: function (j) {return j < 11 || j > 13 ? ['st', 'nd', 'rd', 'th'][Math.min((j - 1) % 10, 3)] : 'th'},
			srcformat: 'Y-m-d',
			newformat: 'm-d-Y',
			parseRe : /[Tt\\\/:_;.,\t\s-]/,
			masks : {
				ISO8601Long:"Y-m-d H:i:s",
				ISO8601Short:"Y-m-d",
				ShortDate: "Y/j/n",
				LongDate: "l, F d, Y",
				FullDateTime: "l, F d, Y g:i:s A",
				MonthDay: "F d",
				ShortTime: "g:i A",
				LongTime: "g:i:s A",
				SortableDateTime: "Y-m-d\\TH:i:s",
				UniversalSortableDateTime: "Y-m-d H:i:sO",
				YearMonth: "F, Y"
			},
			reformatAfterEdit : false
		},
		baseLinkUrl: '',
		showAction: '',
		target: '',
		checkbox : {disabled:true},
		idName : 'id'
	}
});
})(jQuery);
