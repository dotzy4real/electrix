import React, { useEffect, useState } from 'react';
import { Link, useParams, useNavigate  } from 'react-router-dom';
import moment from 'moment';
import NewsImage1 from '../../assets/images/resource/blog/blog1.jpg';
import NewsImage2 from '../../assets/images/resource/blog/blog2.jpg';
import NewsImage3 from '../../assets/images/resource/blog/blog3.jpg';
const imgPath = '/src/assets/images/resource/blog';

function News() {

const { name } = useParams("name");
const { type } = useParams("type");
let id = null;
if (name && typeof name === "string")
{
	id = name.split("-").pop();
}
const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);
const [isTag, setIsTag] = useState(false);
const [isCategory, setIsCategory] = useState(false);

if (type === "category")
{
	useEffect(() => {
		const fetchData = async () => {
		  try {
			const response = await fetch(ApiUrl + "electrix/getBlogCategory/"+id);
			if (!response.ok) {
			  throw new Error(`HTTP error! status: ${response.status}`);
			}
			const result = await response.json();
			setData(result);
		  } catch (error) {
			setError(error);
		  } finally {
			setLoading(false);
			setDataLoaded(true);
		  }
		};
	
		fetchData();
	  }, []);

} else if (type === "tag")
{
	useEffect(() => {
		const fetchData = async () => {
		  try {
			const response = await fetch(ApiUrl + "electrix/getBlogTag"+id);
			if (!response.ok) {
			  throw new Error(`HTTP error! status: ${response.status}`);
			}
			const result = await response.json();
			setData(result);
		  } catch (error) {
			setError(error);
		  } finally {
			setLoading(false);
			setDataLoaded(true);
		  }
		};
	
		fetchData();
	  }, []);

} else
{
useEffect(() => {
	const fetchData = async () => {
	  try {
		const response = await fetch(ApiUrl + "electrix/fetchBlogs");
		if (!response.ok) {
		  throw new Error(`HTTP error! status: ${response.status}`);
		}
		const result = await response.json();
		setData(result);
	  } catch (error) {
		setError(error);
	  } finally {
		setLoading(false);
		setDataLoaded(true);
	  }
	};

	fetchData();
  }, []);
}

    return (
        <>
	    <section className="news-section">
			<div className="auto-container">
				<div className="row">

				{data.map(item => (

				<div key={item.blog_id} className="news-block col-lg-4 col-sm-6 wow fadeInUp">
						<div className="inner-box">
							<div className="image-box">
								<figure className="image"><Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id}><img src={imgPath+"/"+item.blog_pic} alt="Image"/></Link></figure>
								<span className="date"><b>{moment(item.added_time).format('DD')}</b>{moment(item.added_time).format("MMM' YY")}</span>
							</div>
							<div className="content-box">
								<ul className="post-info">
									<li><i className="fa fa-user"></i> By admin</li>
									<li><i className="fa fa-tag"></i> {item.blog_category_name}</li>
								</ul>
								<h4 className="title"><Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id}>{item.blog_title}</Link></h4>
							</div>
							<div className="bottom-box">
								<Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id} className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
								{/*<div className="comments"><i className="fa fa-comments"></i> (05)</div>*/}
							</div>
						</div>
					</div>
 ))}



{/*

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
					</div>*/}
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