import React from 'react';
import { Link } from 'react-router-dom';
import NewsImage1 from '../../assets/images/resource/blog/blog1.jpg';
import NewsImage2 from '../../assets/images/resource/blog/blog2.jpg';
import NewsImage3 from '../../assets/images/resource/blog/blog3.jpg';
function News() {
    return (
        <>
	    <section className="news-section">
			<div className="auto-container">
				<div className="row">
					<div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
						<div className="inner-box">
							<div className="image-box">
								<figure className="image"><Link to="/blog/blog-details"><img src={NewsImage1} alt="Image"/></Link></figure>
								<span className="date"><b>12</b> OCT</span>
							</div>
							<div className="content-box">
								<ul className="post-info">
									<li><i className="fa fa-user"></i> By admin</li>
									<li><i className="fa fa-tag"></i> electrical</li>
								</ul>
								<h4 className="title"><Link to="/blog/blog-details">Smart Home Wiring A Guide for Modern Electricians</Link></h4>
							</div>
							<div className="bottom-box">
								<Link to="/blog/blog-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
								<div className="comments"><i className="fa fa-comments"></i> (05)</div>
							</div>
						</div>
					</div>
					<div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
						<div className="inner-box">
							<div className="image-box">
								<figure className="image"><Link to="/blog/blog-details"><img src={NewsImage2} alt="Image"/></Link></figure>
								<span className="date"><b>12</b> OCT</span>
							</div>
							<div className="content-box">
								<ul className="post-info">
									<li><i className="fa fa-user"></i> By admin</li>
									<li><i className="fa fa-tag"></i> electrical</li>
								</ul>
								<h4 className="title"><Link to="/blog/blog-details">Emergency Electrical Repairs What You Need to Do</Link></h4>
							</div>
							<div className="bottom-box">
								<Link to="/blog/blog-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
								<div className="comments"><i className="fa fa-comments"></i> (05)</div>
							</div>
						</div>
					</div>
					<div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
						<div className="inner-box">
							<div className="image-box">
								<figure className="image"><Link to="/blog/blog-details"><img src={NewsImage3} alt="Image"/></Link></figure>
								<span className="date"><b>12</b> OCT</span>
							</div>
							<div className="content-box">
								<ul className="post-info">
									<li><i className="fa fa-user"></i> By admin</li>
									<li><i className="fa fa-tag"></i> electrical</li>
								</ul>
								<h4 className="title"><Link to="/blog/blog-details">Powering Up: Innovations in Electrical Technology</Link></h4>
							</div>
							<div className="bottom-box">
								<Link to="/blog/blog-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
								<div className="comments"><i className="fa fa-comments"></i> (05)</div>
							</div>
						</div>
					</div>
					{/*
					<div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
						<div className="inner-box">
							<div className="image-box">
								<figure className="image"><Link to="/blog/blog-details"><img src={NewsImage2} alt="Image"/></Link></figure>
								<span className="date"><b>12</b> OCT</span>
							</div>
							<div className="content-box">
								<ul className="post-info">
									<li><i className="fa fa-user"></i> By admin</li>
									<li><i className="fa fa-tag"></i> electrical</li>
								</ul>
								<h4 className="title"><Link to="/blog/blog-details">Emergency Electrical Repairs What You Need to Do</Link></h4>
							</div>
							<div className="bottom-box">
								<Link to="/blog/blog-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
								<div className="comments"><i className="fa fa-comments"></i> (05)</div>
							</div>
						</div>
					</div>
					<div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
						<div className="inner-box">
							<div className="image-box">
								<figure className="image"><Link to="/blog/blog-details"><img src={NewsImage3} alt="Image"/></Link></figure>
								<span className="date"><b>12</b> OCT</span>
							</div>
							<div className="content-box">
								<ul className="post-info">
									<li><i className="fa fa-user"></i> By admin</li>
									<li><i className="fa fa-tag"></i> electrical</li>
								</ul>
								<h4 className="title"><Link to="/blog/blog-details">Powering Up: Innovations in Electrical Technology</Link></h4>
							</div>
							<div className="bottom-box">
								<Link to="/blog/blog-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
								<div className="comments"><i className="fa fa-comments"></i> (05)</div>
							</div>
						</div>
					</div>
					<div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
						<div className="inner-box">
							<div className="image-box">
								<figure className="image"><Link to="/blog/blog-details"><img src={NewsImage1} alt="Image"/></Link></figure>
								<span className="date"><b>12</b> OCT</span>
							</div>
							<div className="content-box">
								<ul className="post-info">
									<li><i className="fa fa-user"></i> By admin</li>
									<li><i className="fa fa-tag"></i> electrical</li>
								</ul>
								<h4 className="title"><Link to="/blog/blog-details">Smart Home Wiring A Guide for Modern Electricians</Link></h4>
							</div>
							<div className="bottom-box">
								<Link to="/blog/blog-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
								<div className="comments"><i className="fa fa-comments"></i> (05)</div>
							</div>
						</div>
					</div>*/}
				</div>
			</div>
		</section>
        </>
    );
}

export default News;