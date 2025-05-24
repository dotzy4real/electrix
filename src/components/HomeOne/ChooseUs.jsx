import React from 'react';
import ProgressBar2 from '../../lib/ProgressBar2.jsx'; 

function ChooseUs({ className }) {
    return (
        <>
            <section className={`why-choose-us ${className || ''}`}>
                <div className="icon-big-drill"/>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="row g-0">
                            <div className="content-column col-lg-6 order-lg-2">
                                <div className="inner-column wow fadeInLeft"> 
                                    <div className="sec-title">
                                        <span className="sub-title">WHO WE ARE</span>
                                        <h2>Providing quality your <br/>Electric services to all</h2>
                                        <div className="text">With over four decades of experience providing solutions to large-scale enterprises throughout the globe, we offer end-to-end logistics tailored for specific markets.</div>
                                    </div>
                                    <div className="skills">
                                        <div className="skill-item">
                                            <div className="skill-header">
                                                <div className="skill-title">Our Successful Work Story</div>
                                            </div>
                                            <ProgressBar2 targetPercentage={85} />
                                        </div>
                                        <div className="skill-item">
                                            <div className="skill-header">
                                                <div className="skill-title">Management</div>
                                            </div>
                                            <ProgressBar2 targetPercentage={75} />
                                        </div>
                                    </div>
                                    <a href="tel:+00(1111)2222" className="info-btn"> <i className="icon fa fa-phone"></i> <small>Call Anytime</small> <strong>+ 00 ( 1111 ) 2222</strong> </a>
                                </div>
                            </div>
                            <div className="features-column col-lg-6">
                                <div className="inner-column">
                                    <div className="shape-2"/>
                                    <div className="title-box">
                                        <h2 className="title words-slide-up text-split">Electrical<br/>Services Are Often<br/>Considered.</h2>
                                    </div>
                                    <div className="feature-block-five">
                                        <div className="inner-box">
                                            <div className="icon-box"><i className="icon flaticon-016-analyzer"></i></div>
                                            <div className="content-box">
                                                <h5 className="title">Consult case</h5>
                                                <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit ridiculus, nunc placerat nulla</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="feature-block-five">
                                        <div className="inner-box">
                                            <div className="icon-box"><i className="icon flaticon-018-tester"></i></div>
                                            <div className="content-box">
                                                <h5 className="title">Make Plan</h5>
                                                <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit ridiculus, nunc placerat nulla</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="feature-block-five mb-0">
                                        <div className="inner-box">
                                            <div className="icon-box"><i className="icon flaticon-015-power-strip"></i></div>
                                            <div className="content-box">
                                                <h5 className="title">Success Project</h5>
                                                <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit ridiculus, nunc placerat nulla</div>
                                            </div>
                                        </div>
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

export default ChooseUs;
