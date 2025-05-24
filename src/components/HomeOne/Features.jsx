import React from 'react';
import { Link } from 'react-router-dom';


function Features({ className }) {
    return (
        <>
            <section className={`features-section pt-0 ${className || ''}`}>
                <div className="auto-container">
                    <div className="row">
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-050-protect"></i>
                                    <div className="number">01</div>
                                </div>
                                <div className="content">
                                    <h5 className="title">
                                        <Link to="/page-about">Professionalism</Link>
                                    </h5>
                                    <div className="text">Consistently practised to the highest possible standard.</div>
                                </div>
                            </div>
                        </div>
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-049-wiring"></i>
                                    <div className="number">02</div>
                                </div>
                                <div className="content">
                                    <h5 className="title"><Link to="/page-about">Innovation</Link></h5>
                                    <div className="text">We bring creativity to the solutions we develop and the work we do.</div>
                                </div>
                            </div>
                        </div>
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-048-crimping"></i>
                                    <div className="number">03</div>
                                </div>
                                <div className="content">
                                    <h5 className="title"><Link to="/page-about">Reliability</Link></h5>
                                    <div className="text">We honour our commitments and never fail to keep them, whatever the cost.</div>
                                </div>
                            </div>
                        </div>
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-047-extension-cord"></i>
                                    <div className="number">04</div>
                                </div>
                                <div className="content">
                                    <h5 className="title"><Link to="/page-about">Integrity</Link></h5>
                                    <div className="text">Honesty and transparency guide all that we do.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Features;
