import React from 'react';
import ContactImage from '../../assets/images/resource/contact7.jpg';


function Contact({ className }) {
    return (
        <>
            <section id="contact" className={`contact-section-seven pb-0 ${className || ''}`}>
                <div className="contact6"/>
                <div className="auto-container">
                    <div className="row align-items-center">
                        <div className="image-column col-lg-6 col-md-12">
                            <div className="inner-column">
                                <figure className="image"><img src={ContactImage} alt="Image"/></figure>
                                <div className="experience">
                                    <div className="inner">
                                        <i className="icon flaticon-032-glove"></i>
                                        <div className="text">Your Innovation, Our Precision <br/>Precision Electronics  for You</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="form-column col-lg-6 col-md-12 col-sm-12">
                            <div className="inner-column">
                                <div className="contact-form-seven wow fadeInLeft">
                                    <div className="sec-title light">
                                        <span className="sub-title">CONTACT US</span>
                                        <h2>Contact Us Let’s Talk Your Any Query.</h2>
                                    </div>
                                    <form id="contact_form" name="contact_form" className="" action="" method="">
                                        <div className="row">
                                            <div className="col-sm-6 form-group">
                                                <div className="">
                                                    <input name="form_name" className="form-control required" type="text" placeholder="Full Name*"/>
                                                </div>
                                            </div>
                                            <div className="col-sm-6 form-group">
                                                <div className="">
                                                    <input name="form_email" className="form-control required email" type="email" placeholder="Email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-sm-6 form-group">
                                                <div className="">
                                                    <input name="form_company" className="form-control required" type="text" placeholder="Company"/>
                                                </div>
                                            </div>
                                            <div className="col-sm-6 form-group">
                                                <div className="">
                                                    <input name="form_address" className="form-control" type="text" placeholder="Address"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div className=" form-group">
                                            <textarea name="form_message" className="form-control required" rows="7" placeholder="Message"></textarea>
                                        </div>
                                        <div className="">
                                            <input name="form_botcheck" className="form-control" type="hidden" value="" />
                                            <button type="submit" className="theme-btn btn-style-one bg-light w-100" data-loading-text="Please wait..."><span className="btn-title">SUBMIT REQUEST</span></button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Contact;
