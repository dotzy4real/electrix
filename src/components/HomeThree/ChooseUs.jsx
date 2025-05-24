import React, { useState } from "react"; 
import ChooseUsImage from '../../assets/images/resource/choose2-1.jpg';

function ChooseUs({ className }) {

    const [activeIndex, setActiveIndex] = useState(1);
    const handleOnClick = (index) => {
        setActiveIndex(index);
    };

    const handleQuantityChange = (item, change) => {
        setQuantities(prevQuantities => {
            const newQuantity = prevQuantities[item] + change;
            return {
                ...prevQuantities,
                [item]: newQuantity > 0 ? newQuantity : 1
            };
        });
    };


    return (
        <>
            <section className={`why-choose-us-two ${className || ''}`}>
                <div className="icon-dots-3"/>
                <div className="auto-container">
                <div className="outer-box">
                    <div className="row">
                    <div className="content-column col-lg-6 wow fadeInLeft" data-wow-delay="300ms">
                        <div className="inner-column">
                        <div className="sec-title"> <span className="sub-title">WHY CHOOSE US</span>
                            <h2 className="words-slide-up text-split">Providing quality your Electric  services to all</h2>
                        </div>
                        <div className="row">
                            <div className="exp-box col-sm-4">
                            <div className="inner">
                                <h1 className="count">20</h1>
                                <h6 className="title">Years Of <br/>Experience</h6>
                            </div>
                            </div>
                            <div className="blocks-column col-sm-8">
                            <div className="choose-block">
                                <div className="inner-box"> <i className="icon flaticon-050-protect"></i>
                                <div className="content">
                                    <h5 className="title">Easy Payments</h5>
                                    <div className="text">Lorem ipsum dolor sit amet<br/>
                                    conse adipiscing</div>
                                </div>
                                </div>
                            </div>
                            <div className="choose-block">
                                <div className="inner-box"> <i className="icon flaticon-049-wiring"></i>
                                <div className="content">
                                    <h5 className="title">End to End Solutions</h5>
                                    <div className="text">Lorem ipsum dolor sit amet<br/>
                                    conse adipiscing</div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div className="tabs-column col-lg-6 wow fadeInRight">
                        <div className="inner-column">
                        <div className="image-box">
                            <figure className="image"><img src={ChooseUsImage} alt="Image"/></figure>
                        </div>
                        <div className="why-us-tabs tabs-box">
                            <div className="btn-box">
                            <ul className="tab-btns tab-buttons">
                                <li className={activeIndex === 1 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(1)} data-tab="#tab1"><span className="title">Our Missions</span></li>
                                <li className={activeIndex === 2 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(2)} data-tab="#tab2"><span className="title">Our Visions</span></li>
                                <li className={activeIndex === 3 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(3)} data-tab="#tab3"><span className="title">Our History</span></li>
                            </ul>
                            </div>
                            <div className="tabs-content">
                                <div className={activeIndex === 1 ? "tab active-tab animated fadeIn" : "tab"} id="tab1">
                                <div className="inner-box">
                                <div className="content-box">
                                    <div className="text">Pretium morbi luctus ad facilisis hendrerit mauris torquent habitant quam cubilia urna, dictumst penatibus praesent at eleifend natoque hac ridiculus tempor blansodales nam tempus vehicula molestie posuere</div>
                                    <ul className="list-style-two">
                                    <li><i className="icon fa fa-check-circle"></i> We are Award Winning Company</li>
                                    <li><i className="icon fa fa-check-circle"></i> Trained & Professional Engineers</li>
                                    <li><i className="icon fa fa-check-circle"></i> Dedicated to a Safe Work Environment</li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div className={activeIndex === 2 ? "tab active-tab animated fadeIn" : "tab"} id="tab2">
                                <div className="inner-box">
                                <div className="content-box">
                                    <div className="text">Pretium morbi luctus ad facilisis hendrerit mauris torquent habitant quam cubilia urna, dictumst penatibus praesent at eleifend natoque hac ridiculus tempor blansodales nam tempus vehicula molestie posuere</div>
                                    <ul className="list-style-two">
                                    <li><i className="icon fa fa-check-circle"></i> We are Award Winning Company</li>
                                    <li><i className="icon fa fa-check-circle"></i> Trained & Professional Engineers</li>
                                    <li><i className="icon fa fa-check-circle"></i> Dedicated to a Safe Work Environment</li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div className={activeIndex === 3 ? "tab active-tab animated fadeIn" : "tab"} id="tab3">
                                <div className="inner-box">
                                <div className="content-box">
                                    <div className="text">Pretium morbi luctus ad facilisis hendrerit mauris torquent habitant quam cubilia urna, dictumst penatibus praesent at eleifend natoque hac ridiculus tempor blansodales nam tempus vehicula molestie posuere</div>
                                    <ul className="list-style-two">
                                    <li><i className="icon fa fa-check-circle"></i> We are Award Winning Company</li>
                                    <li><i className="icon fa fa-check-circle"></i> Trained & Professional Engineers</li>
                                    <li><i className="icon fa fa-check-circle"></i> Dedicated to a Safe Work Environment</li>
                                    </ul>
                                </div>
                                </div>
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
