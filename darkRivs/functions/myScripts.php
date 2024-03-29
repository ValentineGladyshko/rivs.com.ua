<script type="text/javascript">
    function format(data) {
        var HTML = '';
        data.items.forEach(element => {
            HTML +=
                `<div class="row my-2">
                    <div class="col-1"><img src="/${element.image}" class="m-auto" style="display: block; max-height: 40px; max-width: 40px;" alt=""></div>
                    <div class="col-5 h6 font-weight-normal">${element.productName}</div>
                    <div class="col-2 h6 font-weight-normal">${element.price}</div>
                    <div class="col-2 h6 font-weight-normal">${element.count}</div>
                    <div class="col-2 h6 font-weight-normal">${element.totalPrice}</div>
                </div>`;
        });
        return HTML;
    }

    function chevronToggle(img, button) {
        if (button.classList.contains("chevron-down")) {
            button.classList.add("chevron-up");
            button.classList.remove("chevron-down");
            img.src = "/icons/chevron-up.svg"
        } else {
            button.classList.add("chevron-down");
            button.classList.remove("chevron-up");
            img.src = "/icons/chevron-down.svg"
        }
    };

    function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + "").replace(",", "").replace(" ", "");
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
                dec = typeof dec_point === "undefined" ? "." : dec_point,
                s = "",
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return "" + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || "").length < prec) {
                s[1] = s[1] || "";
                s[1] += new Array(prec - s[1].length + 1).join("0");
            }
            return s.join(dec);
        }
</script>