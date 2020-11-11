let formSender;

$(document).ready(function () {

    formSender = new Vue({
        methods: {
            async send(formData) {
                return new Promise((resolve, reject) => {

                    axios
                        .post('/backend/rest/?action=send_form', JSON.stringify(formData))
                        .then(function (response) {
                            $.fancybox.open({
                                src: '#modal-success',
                                opts: {
                                    closeExisting: true,
                                },
                            });
                            resolve("ok");
                        })
                        .catch(function (error) {
                            $.fancybox.open({
                                src: '#modal-error',
                                opts: {
                                    closeExisting: true,
                                },
                            });
                            reject("error");
                        });

                });
            }
        }
    });

    let questionsForm = new Vue({
        el: "#question-form",
        data: {
            name: "",
            phone: "",
            company: "",
            sending: false,
        },
        methods: {
            submitForm() {

                if (this.formIsValid && !this.sending) {

                    this.sending = true;
                    let self = this;
                    let formData = {
                        name: this.name,
                        phone: this.phone,
                        company: this.company
                    };

                    formSender.send(formData)
                        .then(function() {
                            //
                        })
                        .catch(function () {
                        })
                        .finally(function () {
                            self.name = "";
                            self.phone = "";
                            self.company = "";
                            self.sending = false;
                        });

                }

            },
        },
        computed: {
            formIsValid() {
                return (this.name.length > 1 && this.phone.length === 18 && this.company.length > 1);
            },
        }
    });

    $('.logistics__slider').flickity({
        cellAlign: 'left',
        contain: true,
        pageDots: false,
    });

});