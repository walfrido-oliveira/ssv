!function(e){var t={};function n(a){if(t[a])return t[a].exports;var r=t[a]={i:a,l:!1,exports:{}};return e[a].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(a,r,function(t){return e[t]}.bind(null,r));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=54)}({54:function(e,t,n){e.exports=n(55)},55:function(e,t){function n(e){if(e.loading)return e.text;var t=$("<div class='select2-result-contact clearfix'><div class='select2-result-contact__meta'><div class='select2-result-contact__contact'></div><div class='select2-result-contact__department'></div><div class='select2-result-contact__phone'></div><div class='select2-result-contact__mobile_phone'></div><div class='select2-result-contact__email'></div></div></div>");return t.find(".select2-result-contact__contact").text(e.contact),t.find(".select2-result-contact__department").text(e.department),t.find(".select2-result-contact__phone").text(e.phone),t.find(".select2-result-contact__mobile_phone").text(e.mobile_phone),t.find(".select2-result-contact__email").text(e.email),t}function a(e){if(e.loading)return e.text;var t=$("<div class='select2-result-service clearfix'><div class='select2-result-service__meta'><div class='select2-result-service__name'></div></div></div>");return t.find(".select2-result-service__name").text(e.text+" - "+window.currencyFormatDE(e.price)),t}function r(e){if(e.loading)return e.text;var t=$("<div class='select2-result-product clearfix'><div class='select2-result-product__meta'><div class='select2-result-product__name'></div></div></div>");return t.find(".select2-result-product__name").text(e.text+" - "+window.currencyFormatDE(e.price)),t}function c(e){var t=e.contact,n=e.email;return t||(t=""),n||(n=""),""!=t||""!=n?t+" - "+n:e.text}function i(e){var t=e.text,n=e.price;return isNaN(n)?e.text:t+" - "+window.currencyFormatDE(n)}function l(e){var t=e.text,n=e.price;return isNaN(n)?e.text:t+" - "+window.currencyFormatDE(n)}function o(){var e;$(".total-budget").text(window.currencyFormatDE((e=0,$(".total-service-item input").each((function(){e+=parseFloat($(this).val())})),$(".total-services").text(window.currencyFormatDE(e)),e+function(){var e=0;return $(".total-product-item input").each((function(){e+=parseFloat($(this).val())})),$(".total-products").text(window.currencyFormatDE(e)),e}())))}$(document).ready((function(){o(),$("select[name=client_id]").select2({ajax:{url:"/admin/clients/find",dataType:"json",data:function(e){return{q:$.trim(e.term),page:e.page}},processResults:function(e,t){return t.page=t.page||1,{results:e,pagination:{more:30*t.page<e.total_count}}},cache:!0}}),$("select[name=client_id]").on("change",(function(e){$("select[name=client_contact_id]").val(null).trigger("change")})),$("select[name=client_contact_id]").select2({ajax:{url:"/admin/contacts/find",dataType:"json",data:function(e){return{q:$.trim(e.term),client_id:$("select[name=client_id").find(":selected").val(),page:e.page}},processResults:function(e,t){return t.page=t.page||1,{results:e,pagination:{more:30*t.page<e.total_count}}},cache:!0},templateResult:n,templateSelection:c}),$("select[name=service]").select2({ajax:{url:"/admin/services/find",dataType:"json",data:function(e){return{q:$.trim(e.term),page:e.page}},processResults:function(e,t){return t.page=t.page||1,{results:$.map(e,(function(e){return{text:e.text,id:e.id,price:e.price}})),pagination:{more:30*t.page<e.total_count}}},cache:!0},templateResult:a,templateSelection:i}),$("select[name=product]").select2({ajax:{url:"/admin/products/find",dataType:"json",data:function(e){return{q:$.trim(e.term),page:e.page}},processResults:function(e,t){return t.page=t.page||1,{results:e,pagination:{more:30*t.page<e.total_count}}},cache:!0},templateResult:r,templateSelection:l}),$(".btn-add-service").on("click",(function(e){var t=$(".table-service tbody"),n=$("select[name=service]").find(":selected"),a=$("select[name=service]").select2("data")[0],r=$("input[name=service_amount]"),c=t.find("tr").length+1,i='<tr id="row-service-'+(c-1)+'"><td>'+c+'<input type="hidden" name="services['+(c-1)+'][service_id]" value="'+n.val()+'" /><input type="hidden" name="services['+(c-1)+'][index]" value="'+(c-1)+'" /></td><td>'+n.text()+'<input type="hidden" name="services['+(c-1)+'][service_name]" value="'+n.text()+'" /></td><td>'+window.currencyFormatDE(a.price)+'<input type="hidden" name="services['+(c-1)+'][service_price]" value="'+a.price+'" /></td><td>'+r.val()+'<input type="hidden" name="services['+(c-1)+'][amount]" value="'+r.val()+'" /></td><td class="total-service-item">'+window.currencyFormatDE(r.val()*a.price)+'<input type="hidden" name="services['+(c-1)+'][total]" value="'+r.val()*a.price+'" /></td><td width="15%"><a href="#" class="btn btn-danger btn-sm btn-remove-service" data-toggle="modal" data-target="#delete-modal" data-row="row-service-'+(c-1)+'"><i class="fas fa-trash-alt"></i></a></tr>';t.append(i),o(),$("select[name=service]").val(null).trigger("change"),r.val(1),$("#service-modal").modal("hide")})),$(".btn-add-product").on("click",(function(e){var t=$(".table-product tbody"),n=$("select[name=product]").find(":selected"),a=$("select[name=product]").select2("data")[0],r=$("input[name=product_amount]"),c=t.find("tr").length+1,i='<tr id="row-product-'+(c-1)+'"><td>'+c+'<input type="hidden" name="products['+(c-1)+'][product_id]" value="'+n.val()+'" /><input type="hidden" name="products['+(c-1)+'][index]" value="'+(c-1)+'" /></td><td>'+n.text()+'<input type="hidden" name="products['+(c-1)+'][product_name]" value="'+n.text()+'" /></td><td>'+window.currencyFormatDE(a.price)+'<input type="hidden" name="products['+(c-1)+'][product_price]" value="'+a.price+'" /></td><td>'+r.val()+'<input type="hidden" name="products['+(c-1)+'][amount]" value="'+r.val()+'" /></td><td class="total-product-item">'+window.currencyFormatDE(r.val()*a.price)+'<input type="hidden" name="products['+(c-1)+'][total]" value="'+r.val()*a.price+'" /></td><td width="15%"><a href="#" class="btn btn-danger btn-sm btn-remove-product" data-toggle="modal" data-target="#delete-modal" data-row="row-product-'+(c-1)+'"><i class="fas fa-trash-alt"></i></a></tr>';t.append(i),o(),$("select[name=product]").val(null).trigger("change"),r.val(1),$("#product-modal").modal("hide")})),$(".btn-cancel").on("click",(function(e){$("select[name=service]").val(null).trigger("change"),$("input[name=service_amount]").val(1),$("select[name=product]").val(null).trigger("change"),$("input[name=product_amount]").val(1)})),$("#delete-modal").on("show.bs.modal",(function(e){var t=$(e.relatedTarget).data("row");$(".btn-delete").attr("data-row",t)})),$(".btn-delete").on("click",(function(e){var t=$(this).attr("data-row");$("#"+t).remove(),o(),$("#delete-modal").modal("hide")}))}))}});