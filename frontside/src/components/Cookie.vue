
<script>
export default {
    methods: {
        setCookie: function(name, value, daysToLive = 6)
        {
            var cookie = name + "=" + encodeURIComponent(value);
            if(typeof daysToLive === "number") {
                cookie += "; max-age=" + (daysToLive*24*60*60);
                document.cookie = cookie;
            }
        },
        getCookie: function(name)
        {
            var cookieArr = document.cookie.split(";");
            for(var i = 0; i < cookieArr.length; i++)
            {
                var cookiePair = cookieArr[i].split("=");
                if(name == cookiePair[0].trim())
                {
                    return decodeURIComponent(cookiePair[1]);
                }
            }
            return null;
        },
    }
};
</script>
