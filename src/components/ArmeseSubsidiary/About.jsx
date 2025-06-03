import React from 'react';
import { Link } from 'react-router-dom';
import AboutThumbImg from '../../assets/images/armese/emmanuel_audu.jpg';
import AboutSignImg from '../../assets/images/resource/sign-2.png';
import AboutImg1 from '../../assets/images/armese/about1.jpg';
import AboutImg2 from '../../assets/images/armese/about2.jpg';

function About({ className }) {
    return (
        <>
		
    <section id='/Armese#armeseAbout' className={`about-section-four ${className || ''}`}>
		<div className="auto-container">
			<div className="row">
				<div className="content-column col-xl-7 col-md-12 col-sm-12 order-lg-2 wow fadeInRight" data-wow-delay="600ms">
					<div className="inner-column">
						<div className="sec-title">
							<span className="sub-title">WHO WE ARE</span>
							<h2>About Armese Consulting Limited</h2>
							<div className="text">We specialize in conceptualization; power system engineering consulting and strategy; Transaction advisory services for IPPs, DISCOS, and prospective Power Sector Investors; technical audits/techno-economics, tendering/bid support and guideline preparation; and execution of special engineering projects.
							</div>
						</div>

						<ul className="list-style-two style-two">
							<li><i className="fa fa-check-circle"></i> Half a century of focused power experience.</li>
							<li><i className="fa fa-check-circle"></i> Full Spectrum of Services.</li>
							<li><i className="fa fa-check-circle"></i> Sustainable solutions to drive development and economic growth.</li>
							<li><i className="fa fa-check-circle"></i> Proven, senior-level expertise</li>
						</ul>

						<div className="btn-box">
							<div className="founder-info">
								<div className="thumb"><img src={AboutThumbImg} alt="Image"/></div>
								<div className="info">
									<h5 className="name">Dr. (Engr.) Emmanuel Audu-Ohwavborua</h5>
									<span className="designation">Executive Director Technical & Operations</span>
								</div>
							</div>
							<Link to="/board-members" className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></Link>
							{/*<div className="signature-box"><img src={AboutSignImg} alt="Image"/></div>*/}
						</div>
					</div>
				</div>
				<div className="image-column col-xl-5">
					<div className="inner-column wow fadeInLeft">
						<figure className="image-1 overlay-anim wow fadeInUp"><img src={AboutImg1} alt=""/></figure>
						<figure className="image-2 overlay-anim wow fadeInRight"><img src={AboutImg2} alt=""/></figure>
					</div>
				</div>
			</div>
		</div>
	</section>
        </>
    );
}

export default About;
