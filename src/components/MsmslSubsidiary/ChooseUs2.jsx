import React, { useState } from "react"; 
import ChooseUsImage from '../../assets/images/msmsl/mission2.jpg';

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
            <section className={`why-choose-us-two msmsl ${className || ''}`}>
                <div className="icon-dots-3"/>
                <div className="auto-container">
                <div className="outer-box">
                    <div className="row">
                    <div className="content-column col-lg-6 wow fadeInLeft" data-wow-delay="300ms">
                        <div className="inner-column">
                        <div className="sec-title"> <span className="sub-title">WHY CHOOSE US</span>
                            <h2 className="words-slide-up text-split">We provide best efficient metering solution</h2>
                        </div>
                        <div className="row">
                            {/*<div className="exp-box col-sm-4">
                            <div className="inner">
                                <h1 className="count">20</h1>
                                <h6 className="title">Years Of <br/>Experience</h6>
                            </div>
                            </div>*/}
                            <div className="blocks-column col-sm-12">
                            <div className="choose-block">
                                <div className="inner-box"> <i className="icon flaticon-050-protect"></i>
                                <div className="content">
                                    <h5 className="title">Quality: Never Compromise on Standards</h5>
                                    <div className="text">Our metering products are ranked among the best in the market because we are guided by the principle to always deliver nothing less than the best.
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div className="choose-block">
                                <div className="inner-box"> <i className="icon flaticon-049-wiring"></i>
                                <div className="content">
                                    <h5 className="title">Integrity: Guided by Ethics.</h5>
                                    <div className="text">We have earned the trust of our numerous clients, thanks to a legacy of integrity and ethical business standards</div>
                                </div>
                                </div>
                            </div>
                            <div className="choose-block">
                                <div className="inner-box"> <i className="icon flaticon-049-wiring"></i>
                                <div className="content">
                                    <h5 className="title">Customer Satisfaction: Clients Come First</h5>
                                    <div className="text">We prioritize 360-degree client satisfaction because solving our clients’ problems is the reason we are in business</div>
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
                                <li className={activeIndex === 1 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(1)} data-tab="#tab1"><span className="title">Our Mission</span></li>
                                <li className={activeIndex === 2 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(2)} data-tab="#tab2"><span className="title">Our Edge</span></li>
                                {/*<li className={activeIndex === 3 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(3)} data-tab="#tab3"><span className="title">Our History</span></li>*/}
                            </ul>
                            </div>
                            <div className="tabs-content">
                                <div className={activeIndex === 1 ? "tab active-tab animated fadeIn" : "tab"} id="tab1">
                                <div className="inner-box">
                                <div className="content-box">
                                    <div className="text">
                                        <h4>Our Mission</h4>
                                        To consistently deploy the best of our innovative workforce in providing superior cutting-edge solutions and advanced technology equipment for  application in Smart Grid, Energy Conservation and Clean Energy for Utility Companies<br/><br/>
                                        <h4>Our Vision</h4>
                                        To be the preferred and industry Leader in Smart Metering Technology in sub-Sahara Africa 
                                        <br/><br/>
                                        <h4>Our Proposition</h4>
                                        We provide genuinely local content solutions to the electricity metering challenges affecting the Nigerian power sector. 

</div>
{/*
                                    <ul className="list-style-two">
                                    <li><i className="icon fa fa-check-circle"></i> We are Award Winning Company</li>
                                    <li><i className="icon fa fa-check-circle"></i> Trained & Professional Engineers</li>
                                    <li><i className="icon fa fa-check-circle"></i> Dedicated to a Safe Work Environment</li>
                                    </ul>*/}
                                </div>
                                </div>
                            </div>
                            <div className={activeIndex === 2 ? "tab active-tab animated fadeIn" : "tab"} id="tab2">
                                <div className="inner-box">
                                <div className="content-box">
                                    <div className="text">Since inception in September, 2017 MSMSL has made giant strides in the provision of Metering Solutions catering to the domestic and international markets. We count the following as our major achievements, giving us the impetus to do even more in our product delivery.
                                        <br/><br/>
                                    <ul className="list-style-two">
                                    {/*<li><i className="icon fa fa-check-circle"></i> <strong>Local Content</strong>
                                    <br/>We currently employ over 200 staff in a ratio of 99% Nigerian participation to 1% foreign beyond local content specifications.  
                                    </li>*/}
                                    <li><i className="icon fa fa-check-circle"></i> <b>Product</b>
                                    <br/>Our products and services deliver loss reduction mechanisms for distribution companies, accurate electricity measurement to end users and transparency to stakeholders in the power sector value chain.
</li>
                                    <li><i className="icon fa fa-check-circle"></i> <b>Capacity</b>
                                    <br/>Our state-of-the-art manufacturing facility is reputedly the largest in West Africa, with the capacity to produce 3 million meters yearly. It is staffed by a team of seasoned indigenous and international professionals who bring a pedigree of unequalled competence to the table, gleaned from time-tested local and international affiliations.
                                    </li>
                                    </ul></div>
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
