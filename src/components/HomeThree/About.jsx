import React from 'react';
import AboutThumbImg from '../../assets/images/resource/about1-thumb2.jpg';
import AboutSignImg from '../../assets/images/resource/sign-2.png';
import AboutImg1 from '../../assets/images/resource/about4-1.jpg';
import AboutImg2 from '../../assets/images/resource/about4-2.jpg';

function About({ className }) {
    return (
        <>
    <section className={`about-section-four ${className || ''}`}>
		<div className="auto-container">
			<div className="row">
				<div className="content-column col-xl-7 col-md-12 col-sm-12 order-lg-2 wow fadeInRight" data-wow-delay="600ms">
					<div className="inner-column">
						<div className="sec-title">
							<span className="sub-title">WHO WE ARE</span>
							<h2>We provide best Electrical Solution in town.</h2>
							<div className="text">Lorem ipsum dolor sit amet, consectetur notted adipisicing elit sed do eiusmod <br />tempor incididunt ut labore et simply free text dolore magna ediet aliqua lonm <br /> andhn tempor facilisis sag</div>
						</div>

						<ul className="list-style-two style-two">
							<li><i className="fa fa-check-circle"></i> Deliver Perfect Solution for business</li>
							<li><i className="fa fa-check-circle"></i> Readily Work With Global Brands solutions.</li>
							<li><i className="fa fa-check-circle"></i> Residential Business Installation</li>
							<li><i className="fa fa-check-circle"></i> Deliver Perfect Solution for business</li>
						</ul>

						<div className="btn-box">
							<div className="founder-info">
								<div className="thumb"><img src={AboutThumbImg} alt="Image"/></div>
								<div className="info">
									<h5 className="name">Robert Milkwood</h5>
									<span className="designation">Founder</span>
								</div>
							</div>
							<div className="signature-box"><img src={AboutSignImg} alt="Image"/></div>
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
