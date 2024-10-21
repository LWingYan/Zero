! function(t) {
	t.fn.extend({
		shortcuts: function() {
			this.keydown(function(e) {
				var i = t(this);
				if (e.stopPropagation(), e.altKey) switch (e.keyCode) {
					case 67:
						i.insertContent("[code]" + i.selectionRange() + "[/code]")
				}
			})
		},
		insertContent: function(e, i) {
			var n = t(this)[0];
			if (document.selection) {
				this.focus();
				var l = document.selection.createRange();
				l.text = e, this.focus(), l.moveStart("character", -a);
				var o = l.text.length;
				if (2 == arguments.length) {
					var a = n.value.length;
					l.moveEnd("character", o + i), i <= 0 ? l.moveStart("character", o - 2 * i - e.length) : l.moveStart("character", o - i - e.length), l.select()
				}
			} else if (n.selectionStart || "0" == n.selectionStart) {
				var s = n.selectionStart,
					h = n.selectionEnd,
					d = n.scrollTop;
				n.value = n.value.substring(0, s) + e + n.value.substring(h, n.value.length), this.focus(), n.selectionStart = s + e.length, n.selectionEnd = s + e.length, n.scrollTop = d, 2 == arguments.length && (n.setSelectionRange(s - i, n.selectionEnd + i), this.focus())
			} else this.value += e, this.focus()
		},
		selectionRange: function(t, e) {
			var i = "",
				n = this[0];
			if (void 0 === t) i = /input|textarea/i.test(n.tagName) && /firefox/i.test(navigator.userAgent) ? n.value.substring(n.selectionStart, n.selectionEnd) : document.selection ? document.selection.createRange()
				.text : document.getSelection()
				.toString();
			else {
				if (!/input|textarea/.test(n.tagName.toLowerCase())) return !1;
				if (void 0 === e && (e = t), n.setSelectionRange) n.setSelectionRange(t, e), this.focus();
				else {
					var l = n.createTextRange();
					l.move("character", t), l.moveEnd("character", e - t), l.select()
				}
			}
			return void 0 === t ? i : this
		}
	})
}(jQuery), $(function() {
		[{
			title: "删除线",
			id: "wmd-html",
			svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M17.154 14c.23.516.346 1.09.346 1.72 0 1.342-.524 2.392-1.571 3.147C14.88 19.622 13.433 20 11.586 20c-1.64 0-3.263-.381-4.87-1.144V16.6c1.52.877 3.075 1.316 4.666 1.316 2.551 0 3.83-.732 3.839-2.197a2.21 2.21 0 0 0-.648-1.603l-.12-.117H3v-2h18v2h-3.846zm-4.078-3H7.629a4.086 4.086 0 0 1-.481-.522C6.716 9.92 6.5 9.246 6.5 8.452c0-1.236.466-2.287 1.397-3.153C8.83 4.433 10.271 4 12.222 4c1.471 0 2.879.328 4.222.984v2.152c-1.2-.687-2.515-1.03-3.946-1.03-2.48 0-3.719.782-3.719 2.346 0 .42.218.786.654 1.099.436.313.974.562 1.613.75.62.18 1.297.414 2.03.699z" fill="rgba(153,153,153,1)"/></svg>',
			type: "wmd-button",
			text: "~~删除线内容~~"
		}, {
			title: "下划线",
			id: "wmd-html",
			svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 3v9a4 4 0 1 0 8 0V3h2v9a6 6 0 1 1-12 0V3h2zM4 20h16v2H4v-2z" fill="rgba(153,153,153,1)"/></svg>',
			type: "wmd-button",
			text: "<u>下划线内容</u>"
		}, {
			title: "Emoji表情",
			id: "wmd-emoji",
			svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-7h2a3 3 0 0 0 6 0h2a5 5 0 0 1-10 0zm1-2a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm8 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" fill="rgba(153,153,153,1)"/></svg>',
			type: "origin_btn",
			text: "\nEmoji表情\n"
		},{
			title: "图库",
			id: "wmd-photos-button",
			svg: '<svg class="icon" width="20" height="20" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1181"><path d="M896 512A384 384 0 0 0 533.333333 129.066667h-21.333333A384 384 0 0 0 129.066667 490.666667v21.333333A384 384 0 0 0 490.666667 896h21.333333a384 384 0 0 0 384-362.666667v-21.333333z m-85.333333 0v13.013333a128 128 0 0 1-249.813334 23.893334A213.333333 213.333333 0 0 0 721.066667 298.666667 298.666667 298.666667 0 0 1 810.666667 512zM512 213.333333h13.013333a128 128 0 0 1 23.893334 249.813334A213.333333 213.333333 0 0 0 298.666667 302.933333 298.666667 298.666667 0 0 1 512 213.333333zM213.333333 512v-13.013333a128 128 0 0 1 249.813334-23.893334A213.333333 213.333333 0 0 0 302.933333 725.333333 298.666667 298.666667 0 0 1 213.333333 512z m298.666667 298.666667h-13.013333a128 128 0 0 1-23.893334-249.813334A213.333333 213.333333 0 0 0 725.333333 721.066667 298.666667 298.666667 0 0 1 512 810.666667z" p-id="1182"></path></svg>',
			type: "wmd-button",
			text: "\n{photos}\n图集\n{/photos}\n"
		},{
			title: "bilibili视频",
			id: "wmd-bili-button",
			svg: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path d="M7.17157 2.75725L10.414 5.99936H13.585L16.8284 2.75725C17.219 2.36672 17.8521 2.36672 18.2426 2.75725C18.6332 3.14777 18.6332 3.78094 18.2426 4.17146L16.414 5.99936L18.5 5.99989C20.433 5.99989 22 7.56689 22 9.49989V17.4999C22 19.4329 20.433 20.9999 18.5 20.9999H5.5C3.567 20.9999 2 19.4329 2 17.4999V9.49989C2 7.56689 3.567 5.99989 5.5 5.99989L7.585 5.99936L5.75736 4.17146C5.36684 3.78094 5.36684 3.14777 5.75736 2.75725C6.14788 2.36672 6.78105 2.36672 7.17157 2.75725ZM18.5 7.99989H5.5C4.7203 7.99989 4.07955 8.59478 4.00687 9.35543L4 9.49989V17.4999C4 18.2796 4.59489 18.9203 5.35554 18.993L5.5 18.9999H18.5C19.2797 18.9999 19.9204 18.405 19.9931 17.6444L20 17.4999V9.49989C20 8.67146 19.3284 7.99989 18.5 7.99989ZM8 10.9999C8.55228 10.9999 9 11.4476 9 11.9999V13.9999C9 14.5522 8.55228 14.9999 8 14.9999C7.44772 14.9999 7 14.5522 7 13.9999V11.9999C7 11.4476 7.44772 10.9999 8 10.9999ZM16 10.9999C16.5523 10.9999 17 11.4476 17 11.9999V13.9999C17 14.5522 16.5523 14.9999 16 14.9999C15.4477 14.9999 15 14.5522 15 13.9999V11.9999C15 11.4476 15.4477 10.9999 16 10.9999Z" fill="rgba(153,153,153,1)"></path></svg>',
			type: "wmd-button",
			text: '\n{cat_bili p="1" key="这里输入B站BV号"}\n'
		}].forEach(t => {
			let e = $(`<li class="${t.type}" id="${t.id}" title="${t.title}">${t.svg}</li>`);
			e.on("click", function() {
					"wmd-button" == t.type && $("#text")
						.insertContent(t.text)
				}), $("#wmd-button-row")
				.append(e)
		})
	}), $(function() {
		$("#wmd-hide-button")
			.before('<li id="wmd-spacer2" class="wmd-spacer"></li>'), $("#wmd-bili-button")
			.after('<li class="wmd-spacer" id="wmd-spacer2"></li><button title="发表" style="box-shadow: unset;padding: 0.5rem;vertical-align: middle;line-height: 0.5rem;border: unset;margin: 0.2rem;border-radius: 20%!important;background: unset;" type="submit" class="btn primary" id="btn-submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.596 1.04l6.347 6.346a.5.5 0 0 1-.277.848l-1.474.23-5.656-5.656.212-1.485a.5.5 0 0 1 .848-.283zM4.595 20.15c3.722-3.331 7.995-4.328 12.643-5.52l.446-4.018-4.297-4.297-4.018.446c-1.192 4.648-2.189 8.92-5.52 12.643L2.454 18.01c2.828-3.3 3.89-6.953 5.303-13.081l6.364-.707 5.657 5.657-.707 6.364c-6.128 1.414-9.782 2.475-13.081 5.303L4.595 20.15zm5.284-6.03a2 2 0 1 1 2.828-2.828A2 2 0 0 1 9.88 14.12z" fill="rgba(153,153,153,1)"/></svg></button><hr id="emojistart" style="border: unset;">');
		var t = "😀 😁 😂 😃 😄 😅 😆 😉 😊 😋 😎 😍 😘 😗 😙 😚 😇 😐 😑 😶 😏 😣 😥 😮 😯 😪 😫 😴 😌 😛 😜 😝 😒 😓 😔 😕 😲 😷 😖 😞 😟 😤 😢 😭 😦 😧 😨 😬 😰 😱 😳 😵 😡 😠".split(" "),
			e = "<div class='emojiblock' style='display:none;'>";
		t.forEach(function(t) {
				e += "<span class='editor_emoji'>" + t + "</span>"
			}), e += "</div>", $("#emojistart")
			.after(e)
	}), $(document)
	.on("click", ".editor_emoji", function() {
		var t = $(this)
			.text();
		$("#wmd-editarea textarea")
			.insertContent(t), $("#wmd-editarea textarea")
			.focus()
	}), window.onload = function() {
		$(document)
			.ready(function() {
				$("#custom-field")
					.length > 0 && ($(document)
						.on("click", "#wmd-emoji", function() {
							$(".emojiblock")
								.slideToggle()
						}), $(document)
						.on("click", "#wmd-table-button", function() {
							$("body")
								.append('<div id="postPanel"><div class="wmd-prompt-background" style="position: fixed; top: 0px; z-index: 1000; opacity: 0.5; height: 100%; left: 0px; width: 100%;"></div><div class="wmd-prompt-dialog"><div><h3><label class="typecho-label">插入表格</label></h3><label>表格行</label><input type="number" style="width: 50px; margin: 10px; padding: 7px;" value="3" autocomplete="off" name="A"><label>表格列</label><input type="number" style="width: 50px; margin: 10px; padding: 7px;" value="3" autocomplete="off" name="B"></div><form><button type="button" class="btn btn-s primary" id="wmd-table-button_ok">确定</button><button type="button" class="btn btn-s" id="post_cancel">取消</button></form></div></div>')
						}), $(document)
						.on("click", "#wmd-table-button_ok", function() {
							let t = $(".wmd-prompt-dialog input[name='A']")
								.val(),
								e = $(".wmd-prompt-dialog input[name='B']")
								.val();
							isNaN(t) && (t = 3), isNaN(e) && (e = 3);
							let i = "",
								n = "",
								l = "";
							for (let t = 0; t < e; t++) i += "| 表头 ", n += "| :--: ";
							for (let i = 0; i < t; i++) {
								for (let t = 0; t < e; t++) l += "| 表格 ";
								l += "|\n"
							}
							const o = `${i}|\n${n}|\n${l}\n`;
							$("#text")
								.insertContent(o), $("#postPanel")
								.remove(), $("#wmd-editarea textarea")
								.focus()
						}), $(document)
						.on("click", "#post_cancel", function() {
							$("#postPanel")
								.remove(), $("#wmd-editarea textarea")
								.focus()
						}))
			})
	};