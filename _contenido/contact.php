<!-- send me an email form-->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Contáctanos</h2>
                <h3 class="section-subheading text-primary">Para conocer más, o simplemente decir ¡hola!</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form name="sentMessage" id="contactForm" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Tu nombre *" id="name" required data-validation-required-message="Por favor escribe tu nombre">
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Tu Email *" id="email" required data-validation-required-message="Por favor escribe tu Email">
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Tu número de teléfono *" id="phone" required data-validation-required-message="Por favor escribe tu número telefónico">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Tu Mensaje *" id="message" required data-validation-required-message="Por favor escribe tu mensaje"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <div id="success"></div>
                            <div class="animate buzz">
                                <button type="submit" class="btn btn-xl">Enviar mensaje</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
