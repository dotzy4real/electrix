import React from 'react';
import CounterUp from '../../lib/CounterUp.jsx'; 
import CounterUp3 from '../../lib/CounterUp3.jsx'; 

function FunFact({ className }) {
    const percentage1 = 25;
    const percentage2 = 90;
    const percentage3 = 11;
    const percentage4 = 20;


    return (
        <>
            <section className={`fun-fact-section style-two ${className || ''}`}>
                    <div className="auto-container">
                    <div className="fact-counter">
                        <div className="row">
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-005-accumulator"></i></div><br />
                            <div className="content-box">
                                <div className="count-box">
                                    <CounterUp count={percentage1} time={3} />
                                </div>
                                <div className="counter-title">Years Of Experience</div>
                            </div>
                            </div>
                        </div>
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="600ms">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-050-protect"></i></div><br />
                            <div className="count-box">
                                <CounterUp count={percentage2} time={3} />
                            </div>
                            <div className="counter-title">Satisfied Clients</div>
                            </div>
                        </div>
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="300ms">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-031-led-lamp"></i></div><br />
                            <div className="count-box">
                                <CounterUp3 count={percentage3} time={3} />
                            </div>
                            <div className="counter-title">Project Complete</div>
                            </div>
                        </div>
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="900ms">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-032-glove"></i></div><br />
                            <div className="count-box">
                                <CounterUp count={percentage4} time={3} />
                            </div>
                            <div className="counter-title">Awards Wining</div>
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