import React from 'react';

function Cta({ className }) {
    return (
        <>
            <section className={`call-to-action-three ${className || ''}`}>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="row align-items-center">
                            <div className="content-column col-xl-6 col-lg-6">
                                <div className="inner-column">
                                    <h3 className="title">24/7 Support for help Electrician <br />Work at +00-11-00-2222</h3>
                                </div>
                            </div>
                            <div className="form-column col-xl-6 col-lg-6">
                                <div className="inner-column">
                                    <div className="contact-form-three">
                                        <form method="#" action="#" id="contact-form">
                                            <div className="row">
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="first_name" placeholder="Name" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="email" placeholder="Enter Email" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="date" placeholder="Select Date" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <button type="submit" className="theme-btn btn-style-one bg-dark" name="submit-form"><span className="btn-title">BOOKING NOW</span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Cta;
