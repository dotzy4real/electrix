import React from 'react';
import { Link } from 'react-router-dom';
import processImage from '../../assets/images/resource/process1-1.png';
import processBgImage from '../../assets/images/background/12.jpg';

function Process({ className }) {
    return (
        <>

    <section className={`process-section ${className || ''}`}>
		<div className="bg bg-image" style={{ backgroundImage: `url(${processBgImage})` }}/>
		<div className="float-image"><img src={processImage} alt="Image"/></div>
		<div className="auto-container">
			<div className="sec-title text-center light">
				<span className="sub-title">HOW WE WORK</span>
				<h2>3 Steps Process to <br />Deliver your Services</h2>
			</div>
			<div className="row">
				<div className="process-block col-lg-4 col-sm-6 wow fadeInUp">
					<div className="inner-box">
						<div className="icon-box"><i className="icon flaticon-035-voltmeter"></i></div>
						<div className="content">
							<h4 className="title"><a href="page-contact.html">Request Quote</a></h4>
							<div className="text">We strongly support best practice sharing across our operations around .</div>
							<h4 className="count">01</h4>
							<div className="icon-shapes"></div>
						</div>
					</div>
				</div>
				<div className="process-block col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="300ms">
					<div className="inner-box">
						<div className="icon-box"><i className="icon flaticon-034-hammer"></i></div>
						<div className="content">
							<h4 className="title"><Link to="/page-services">Select Services</Link></h4>
							<div className="text">We strongly support best practice sharing across our operations around .</div>
							<h4 className="count">02</h4>
							<div className="icon-shapes"></div>
						</div>
					</div>
				</div>
				<div className="process-block col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="600ms">
					<div className="inner-box">
						<div className="icon-box"><i className="icon flaticon-033-cutter"></i></div>
						<div className="content">
							<h4 className="title"><Link to="/page-services">Enjoy Services</Link></h4>
							<div className="text">We strongly support best practice sharing across our operations around .</div>
							<h4 className="count">03</h4>
							<div className="icon-shapes"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
        </>
    );
}

export default Process;
