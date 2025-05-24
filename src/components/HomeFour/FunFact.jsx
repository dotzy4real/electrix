import React from 'react';
import { Link } from 'react-router-dom';
import CounterUp2 from '../../lib/CounterUp2.jsx';  
import FunFactImage from '../../assets/images/resource/float-img-8.png';

function FunFact({ className }) {
    const percentage1 = 3220;
    const percentage2 = 2501;
    const percentage3 = 4500;
    const percentage4 = 3020;


    return (
        <>
            <section className={`fun-fact-section-two ${className || ''}`}>
                <div className="shape-21"/>
                <div className="auto-container">
                    <div className="row">
                        <div className="content-column col-xl-6">
                            <div className="inner-column">					
                                <div className="sec-title">
                                    <span className="sub-title">OUR BENIFITIES</span>
                                    <h2>Why You should <br />Choose us</h2>
                                    <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit velit convallis enim vestibulum sagittis sapien ac inceptos eget sociosqu volutpat integer <br /> sem curae nisl magnis montes eros et parturient.</div>
                                </div>
                                <Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></Link>
                            </div>
                        </div>
                        <div className="fact-counter col-xl-6">
                            <div className="row">
                            <div className="counter-block-two col-lg-6 col-md-6 col-sm-6">
                                <div className="inner-box">
                                <div className="icon-box"><i className="icon flaticon-004-solar-panel"></i></div>
                                <div className="content-box">
                                    <div className="count-box">
                                    <CounterUp2 count={percentage1} time={3} />
                                    </div>
                                    <div className="counter-title">Years Of Experience</div>
                                </div>
                                </div>
                            </div>
                            <div className="counter-block-two col-lg-6 col-md-6 col-sm-6">
                                <div className="inner-box">
                                <div className="icon-box"><i className="icon flaticon-039-fuse"></i></div>
                                <div className="content-box">
                                    <div className="count-box">
                                    <CounterUp2 count={percentage2} time={3} />
                                    </div>
                                    <div className="counter-title">Satisfied Clients</div>
                                </div>
                                </div>
                            </div>
                            <div className="counter-block-two col-lg-6 col-md-6 col-sm-6">
                                <div className="inner-box">
                                <div className="icon-box"><i className="icon flaticon-038-motor"></i></div>
                                <div className="content-box">
                                    <div className="count-box">
                                    <CounterUp2 count={percentage3} time={3} />
                                    </div>
                                    <div className="counter-title">Project Complete</div>
                                </div>
                                </div>
                            </div>
                            <div className="counter-block-two col-lg-6 col-md-6 col-sm-6">
                                <div className="inner-box">
                                <div className="icon-box"><i className="icon flaticon-045-switch"></i></div>
                                <div className="content-box">
                                    <div className="count-box">
                                    <CounterUp2 count={percentage4} time={3} />
                                    </div>
                                    <div className="counter-title">Awards Wining Company</div>
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

export default FunFact;