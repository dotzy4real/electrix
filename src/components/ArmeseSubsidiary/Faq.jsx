import React, { useState } from 'react';
import ModalVideo from 'react-modal-video';
import Accordion from '../../lib/Accordion';
import FaqImage from '../../assets/images/resource/image-6.jpg';


function Faq({ className }) {
	const [isOpen, setOpen] = useState(false);
    return (
        <>
			{/* <!-- Faq's Section --> */}
			<section className={`offer-section ${className || ''}`}>
				<div className="auto-container">
					<div className="row">
						<div className="content-column col-lg-6 col-md-12">
							<div className="inner-column">
								<div className="info-box">
									<div className="inner">
										<i className="icon flaticon-business-030-settings"></i>
										<h3 className="title">Highly specialized, <br/>Craft Compliance <br/>Team.</h3>
									</div>
								</div>
								<Accordion />
							</div>
						</div>
						<div className="image-column col-lg-6 col-md-12 col-sm-12">
							<div className="inner-column">
								<div className="image-box">
									<figure className="image overlay-anim"><img src={FaqImage} alt="Faq Img"/></figure>
									<div className="video-box">
										<a onClick={() => setOpen(true)} className="play-btn lightbox-image"><i className="icon fa fa-play"></i></a>
										<ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			{/* <!-- End Faq's Section --> */}
        </>
    );
}

export default Faq;
