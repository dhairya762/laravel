var Base = function() {};

Base.prototype = {
    url: null,
    params: {},
    method: 'post',

    setUrl: function(url) {

        if (!url == 'undefined') {
            //alert(url);
            if (!url.includes('http://127.0.0.1:8000')) {

                url = "http://127.0.0.1:8000" + url;

            }
        }

        this.url = url;
        return this;

    },

    getUrl: function() {
        return this.url;
    },

    setMethod: function(method) {
        this.method = method;
        return this;

    },

    getMethod: function() {
        return this.method;
    },

    resetParams: function() {
        this.params = {};
        return this;
    },

    setParams: function(params) {
        this.params = params;
        return this;
    },

    getParams: function(key) {
        if (typeof key === 'undefined') {
            return this.params;
        }
        if (typeof this.params[key] == 'undefined') {
            return null;
        }
        return this.params[key];
    },

    addParam: function(key, value) {
        this.params[key] = value;
        return this;
    },

    removeParam: function(key) {
        if (typeof this.params[key] != 'undefined') {
            delete this.params[key];
        }
        return this;
    },

    load: function() {
        //console.log(this);
        var self = this;


        $.ajax({

            method: this.getMethod(),
            url: this.getUrl(),
            data: this.getParams(),
            success: function(response) {
                self.manageHtml(response);
            }
        });
    },

    changeAction:function (form,action) {
        var str1 = '#';
        var id = str1+form;
        $(id).attr('action',action);
        this.setForm(form);
    },
    
    setForm:function(form){
        var str1 = '#';
        var id = str1+form;
        this.setParams($(id).serializeArray());
        this.setMethod($(id).attr('method'));
        this.setUrl($(id).attr('action'));
        this.load();
    },


    setImage: function(form) {
        var self = this;
        var formData = new FormData();
        var csrftoken = document.getElementsByName('_token')[0].value;
        var file = $("#image")[0].files;
        formData.append('image', file[0]);
        formData.append('_token', csrftoken);

        this.setParams(formData);
        var str1 = '#';
        var id = str1+form;
        this.setParams($(id).serializeArray());
        this.setMethod($(id).attr('method'));
        this.setUrl($(id).attr('action'));

        var request = $.ajax({
            method: this.getMethod(),
            url: this.getUrl(),
            contentType: false,
            processData: false,
            catch: false,
            data: formData,
            success: function(response) {
                self.manageHtml(response);
            }
        });

        return this;
    },

    // setImage:function(){
    //     var self = this;
    //     var formData = new FormData();
    //     var files = $('#image')[0].files[0];
    //     formData.append('image',files);
        
    //     var id = $('#form').attr('id');
    //     jQuery.ajax({
    //         url:$(id).attr('action'),
    //         type:$(id).attr('method'),
    //         data: formData,
    //         contentType:false,
    //         cache:false,
    //         processData:false,
    //         success:function(data){
    //             self.manageHtml(data);
    //         }
    //     });
    // },

    manageHtml: function(response) {
        if (typeof response.element == 'undefined') {
            return false;
        }

        if (typeof response.element == 'object') {
            $(response.element).each(function(i, element) {
                $(element.selector).html(element.html);
            })
        } else {
            $(response.element.selector).html(response.element.html);
        }
    }
}

var mage = new Base();