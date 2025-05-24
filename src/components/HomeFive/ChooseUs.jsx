import React, { useState } from 'react';
import ModalVideo from 'react-modal-video';
import PricingBgImage1 from '../../assets/images/background/32.png';
import PricingImage2 from '../../assets/images/background/6.jpg';
import PricingImage1 from '../../assets/images/resource/float-img-9.png';

function ChooseUs({ className }) {
	const [isOpen, setOpen] = useState(false);
    return (
        <>
			<section className={`why-choose-us-five ${className || ''}`}>
				<div className="bg-image" style={{ backgroundImage: `url(${PricingBgImage1})` }}/>
				<div className="float-image wow zoomInLeft bounce-x"><img src={PricingImage1} alt="Image"/></div>
				<div className="shape-24"/>
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-xl-6">
							<div className="inner-column wow fadeInLeft">
								<div className="sec-title">
									<span className="sub-title">WHY CHOOSE US</span>
									<h2>Services that help our <br className="d-none d-md-block" />customers meet</h2>
									<div className="text">With over four decades of experience providing solutions to large-scale enterprises throughout the globe, we offer end-to-end.</div>
								</div>

								<div className="row">
									<div className="feature-block-seven col-sm-6">
										<div className="inner-box">
											<i className="icon flaticon-028-pcb-board"></i>
											<h4 className="title">Quality Materials</h4>
											<p className="text">Lorem ipsum dolor sit amet conse ipiscing elit nascetur arcu.</p>
										</div>
									</div>
									<div className="feature-block-seven col-sm-6">
										<div className="inner-box">
											<i className="icon flaticon-029-electric-meter"></i>
											<h4 className="title">Expert Electrician</h4>
											<p className="text">Lorem ipsum dolor sit amet conse ipiscing elit nascetur arcu.</p>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="image-box hide-desktop">
								<img src={PricingImage2} alt="Image"/>
							</div>
							<div className="inner-column">
								<div className="video-box">
									<a onClick={() => setOpen(true)} className="play-now-three lightbox-image"><i className="icon fa fa-play"></i></a>
									<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
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
