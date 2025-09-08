import React, { useEffect, useState } from 'react';
import { Link, useParams, useNavigate  } from 'react-router-dom';
import moment from 'moment';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import NewsDetailsImage from '../../assets/images/resource/blog/blog1.jpg';
import Thumb1 from '../../assets/images/resource/testi-1.jpg';
import Thumb2 from '../../assets/images/resource/testi-2.jpg';
import News1 from '../../assets/images/resource/news-1.jpg';
import News2 from '../../assets/images/resource/news-2.jpg';
import News3 from '../../assets/images/resource/news-3.jpg';
import PageBanner from '../../assets/images/resource/pagebanners/blog.jpeg';
const bannerPath = '/src/assets/images/resource/pagebanners';
const imgPath = '/src/assets/images/resource/blog';

function NewsDetails() {
    
    const { title } = useParams("title");
    let id = null;
    if (title && typeof title === "string")
    {
      id = title.split("-").pop();
    }
    const ApiUrl = import.meta.env.VITE_API_URL;
    const [data, setData] = useState([]);
    const [blog, setBlog] = useState([]);
    const [posts, setPosts] = useState([]);
    const [blogTags, setBlogTags] = useState([]);
    const [categories, setCategories] = useState([]);
    const [tags, setTags] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [dataLoaded, setDataLoaded] = useState(false);
    let isBlogTag = false;
    let blogTagMsg = "";
    let blogExist = false;
    
    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "electrix/getBlog/" + id);
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            setBlog(result);
          } catch (error) {
            setError(error);
          } finally {
            setLoading(false);
            setDataLoaded(true);
          }
        };
    
        fetchData();
      }, [id]);
      
      
      useEffect(() => {
          const fetchData = async () => {
            try {
              const response = await fetch(ApiUrl + "electrix/getPage/blog");
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              const result = await response.json();
              setData(result);
            } catch (error) {
              setError(error);
            } finally {
              setLoading(false);
            }
          };
      
          fetchData();
        }, []);
    
        useEffect(() => {
            const fetchData = async () => {
              try {
                const response = await fetch(ApiUrl + "electrix/recentBlogPosts");
                if (!response.ok) {
                  throw new Error(`HTTP error! status: ${response.status}`);
                }
                const result = await response.json();
                setPosts(result);
              } catch (error) {
                setError(error);
              } finally {
                setLoading(false);
                setDataLoaded(true);
              }
            };
        
            fetchData();
          }, []);
    
          useEffect(() => {
              const fetchData = async () => {
                try {
                  const response = await fetch(ApiUrl + "electrix/blogCategories");
                  if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                  }
                  const result = await response.json();
                  setCategories(result);
                } catch (error) {
                  setError(error);
                } finally {
                  setLoading(false);
                  setDataLoaded(true);
                }
              };
          
              fetchData();
            }, []);
    
            useEffect(() => {
                const fetchData = async () => {
                  try {
                    const response = await fetch(ApiUrl + "electrix/blogTags");
                    if (!response.ok) {
                      throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const result = await response.json();
                    setTags(result);
                  } catch (error) {
                    setError(error);
                  } finally {
                    setLoading(false);
                    setDataLoaded(true);
                  }
                };
            
                fetchData();
              }, []);
    
              useEffect(() => {
                  const fetchData = async () => {
                    try {
                      const response = await fetch(ApiUrl + "electrix/getBlogTagByBlogId/" + id);
                      if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                      }
                      const result = await response.json();
                      setBlogTags(result);
                    } catch (error) {
                      setError(error);
                    } finally {
                      setLoading(false);
                      setDataLoaded(true);
                    }
                  };
              
                  fetchData();
                }, []);

                if (blogTags.length > 0)
                {
                console.log("inside blog tag length is: " + blogTags.length);
                console.log(isBlogTag);
                    isBlogTag = true;
                    console.log(isBlogTag);
                }


                if (isBlogTag)
                {
                    blogTagMsg = "<div><p class='blog-details__tags'> <span>Tags</span>";
                     blogTags.map(item => (
                        blogTagMsg += `<a href="/blog/tag/${item.blog_tag_urltitle}-${item.blog_tag_id}">${item.blog_tag_name}</a>`
                    ));
                    blogTagMsg += "</p></div>";
                }
                console.log("blog tag msg: " + blogTagMsg);


                if (Object.keys(blog).length !== 0)
                {
                  blogExist = true;
                }


    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Blog"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/blog', title: data.page_title },
                    { title: blog.blog_title },
                ]}
                banner={bannerPath+"/"+data.page_banner}
            />
            <section className="blog-details">
                <div className="container">
                    <div className="row">
                        <div className="col-xl-8 col-lg-7">
                          

{ !blogExist ?             
                                    <div dangerouslySetInnerHTML={{ __html: "<h4>The blog post you are looking for does not exist</h4>" }} /> : "" }

 
    {blogExist &&
                            <div className="blog-details__left">
                                <div className="blog-details__img">
                                    <img src={imgPath+"/"+blog.blog_pic} alt="Image"/>
                                    <div className="blog-details__date">
                                        <span className="day">{moment( blog.added_time).format('DD')}</span>
                                        <span className="month">{moment(blog.added_time).format("MMM' YY")}</span>
                                    </div>
                                </div>
                                <div className="blog-details__content">
                                    <ul className="list-unstyled blog-details__meta">
                                        <li><Link to=""><i className="fas fa-user-circle"></i> Admin</Link> </li>
                                        {/*<li><Link to="/blog/blog-details"><i className="fas fa-comments"></i> 02 Comments</Link></li>*/}
                                    </ul>
                                    <h3 className="blog-details__title">{blog.blog_title}</h3>
                                    <p className="blog-details__text-2">                                        
                                    <div dangerouslySetInnerHTML={{ __html: blog.blog_content }} />
                                        {/*Mauris non dignissim purus, ac commodo diam. Donec sit amet lacinia nulla. Aliquam quis purus in justo pulvinar tempor. Aliquam tellus nulla, sollicitudin at euismod nec, feugiat at nisi. Quisque vitae odio nec lacus interdum tempus. Phasellus a rhoncus erat. Vivamus vel eros vitae est aliquet. 
                                        <br/><br/>
                                        Mauris non dignissim purus, ac commodo diam. Donec sit amet lacinia nulla. Aliquam quis purus in justo pulvinar tempor. Aliquam tellus nulla, sollicitudin at euismod nec, feugiat at nisi. Quisque vitae odio nec lacus interdum tempus. Phasellus a rhoncus erat. Vivamus vel eros vitae est aliquet. 
                                    <br/><br/>
                                    Mauris non dignissim purus, ac commodo diam. Donec sit amet lacinia nulla. Aliquam quis purus in justo pulvinar tempor. Aliquam tellus nulla, sollicitudin at euismod nec, feugiat at nisi. Quisque vitae odio nec lacus interdum tempus. Phasellus a rhoncus erat. Vivamus vel eros vitae est aliquet. */}</p>
                                </div>
                                <div className="blog-details__bottom">
                                <div dangerouslySetInnerHTML={{ __html: blogTagMsg }} />
                                    {/*<Link to="/blog/blog-details">Business</Link> <Link to="/blog/blog-details">Agency</Link>*/}
                                    <div className="blog-details__social-list"> <Link to="/blog/blog-details"><i className="fab fa-twitter"></i></Link> <Link to={"/blog/tag/"}><i className="fab fa-facebook"></i></Link> <Link to="/blog/blog-details"><i className="fab fa-pinterest-p"></i></Link> <Link to="/blog/blog-details"><i className="fab fa-instagram"></i></Link> </div>
                                    </div>
                                </div>
}
                                {/*
                                <div className="nav-links">
                                    <div className="prev">
                                        <Link to="/blog/blog-details" rel="prev">Bring to the table win-win survival strategies</Link>
                                    </div>
                                    <div className="next">
                                        <Link to="/blog/blog-details" rel="next">How to lead a healthy &amp; well-balanced life</Link>
                                    </div>
                                </div>
                                <div className="comment-one">
                                    <h3 className="comment-one__title">2 Comments</h3>
                                    <div className="comment-one__single">
                                        <div className="comment-one__image"> <img src={Thumb2} alt="Image"/> </div>
                                        <div className="comment-one__content">
                                            <h3>Kevin Martin</h3>
                                            <p>Mauris non dignissim purus, ac commodo diam. Donec sit amet lacinia nulla. Aliquam quis purus in justo pulvinar tempor. Aliquam tellus nulla, sollicitudin at euismod.
                                            </p>
                                            <Link to="/blog/blog-details" className="theme-btn btn-style-two comment-one__btn"><span className="btn-title">Reply</span></Link>
                                        </div>
                                    </div>
                                    <div className="comment-one__single">
                                        <div className="comment-one__image"> <img src={Thumb1} alt="Image"/> </div>
                                        <div className="comment-one__content">
                                            <h3>Sarah Albert</h3>
                                            <p>Mauris non dignissim purus, ac commodo diam. Donec sit amet lacinia nulla. Aliquam quis purus in justo pulvinar tempor. Aliquam tellus nulla, sollicitudin at euismod.
                                            </p>
                                            <Link to="/blog/blog-details" className="theme-btn btn-style-two comment-one__btn"><span className="btn-title">Reply</span></Link>
                                        </div>
                                    </div>
                                    <div className="comment-form">
                                        <h3 className="comment-form__title">Leave a Comment</h3>
                                        <form id="contact_form" name="contact_form" action="/news-details" method="get">
                                            <div className="row">
                                                <div className="col-sm-6">
                                                    <div className="mb-3">
                                                        <input name="form_name" className="form-control" type="text" placeholder="Enter Name"/>
                                                    </div>
                                                </div>
                                                <div className="col-sm-6">
                                                    <div className="mb-3">
                                                        <input name="form_email" className="form-control required email" type="email" placeholder="Enter Email"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="mb-3">
                                                <textarea name="form_message" className="form-control required" rows="5" placeholder="Enter Message"></textarea>
                                            </div>
                                            <div className="mb-3">
                                                <input name="form_botcheck" className="form-control" type="hidden" value="" />
                                                <button type="submit" className="theme-btn btn-style-two" data-loading-text="Please wait..."><span className="btn-title">Submit Comment</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>*/}
                            </div>
                        <div className="col-xl-4 col-lg-5">
                            <div className="sidebar">
                                <div className="sidebar__single sidebar__search">
                                    <form action="#" className="sidebar__search-form">
                                        <input type="search" placeholder="Search here"/>
                                        <button type="submit"><i className="lnr-icon-search"></i></button>
                                    </form>
                                </div>
                                <div className="sidebar__single sidebar__post">
                                    <h3 className="sidebar__title">Latest Posts</h3>
                                    <ul className="sidebar__post-list list-unstyled">

                                    { posts.map(item => (

                                        <li>
                                            <div className="sidebar__post-image"> <Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id}><img src={imgPath+"/"+item.blog_pic} alt="Image"/></Link> </div>
                                            <div className="sidebar__post-content">
                                                <h3> <span className="sidebar__post-content-meta"><i className="fas fa-user-circle"></i>Admin</span> <Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id}>{item.blog_title}</Link>
                                                </h3>
                                            </div>
                                        </li>

                                    ))}

{/*
                                        <li>
                                            <div className="sidebar__post-image"> <img src={News1} alt="Image"/> </div>
                                            <div className="sidebar__post-content">
                                                <h3> <span className="sidebar__post-content-meta"><i className="fas fa-user-circle"></i>Admin</span> <Link to="/blog/blog-details">Top crypto exchange influencers</Link>
                                                </h3>
                                            </div>
                                        </li>
                                        <li>
                                            <div className="sidebar__post-image"> <img src={News2} alt="Image"/> </div>
                                            <div className="sidebar__post-content">
                                                <h3> <span className="sidebar__post-content-meta"><i className="fas fa-user-circle"></i>Admin</span> <Link to="/blog/blog-details">Necessity may give us best virtual court</Link> </h3>
                                            </div>
                                        </li>
                                        <li>
                                            <div className="sidebar__post-image"> <img src={News3} alt="Image"/> </div>
                                            <div className="sidebar__post-content">
                                                <h3> <span className="sidebar__post-content-meta"><i className="fas fa-user-circle"></i>Admin</span> <Link to="/blog/blog-details">You should know about business plan</Link> </h3>
                                            </div>
                                        </li>*/}
                                    </ul>
                                </div>
                                <div className="sidebar__single sidebar__category">
                                    <h3 className="sidebar__title">Categories</h3>
                                    <ul className="sidebar__category-list list-unstyled">

                                    { categories.map(item => (
                                        <li className={blog.blog_category_id == item.blog_category_id ? 'active' : ''}><Link to={"/blog/category/"+item.blog_category_urltitle+"-"+item.blog_category_id}>{item.blog_category_name}<span className="icon-right-arrow"></span></Link> </li>
                                    ))}
{/*
                                        <li><Link to="/blog/blog-details">Business<span className="icon-right-arrow"></span></Link> </li>
                                        <li className="active"><Link to="/blog/blog-details">Digital Agency<span className="icon-right-arrow"></span></Link></li>
                                        <li><Link to="/blog/blog-details">Introductions<span className="icon-right-arrow"></span></Link> </li>
                                        <li><Link to="/blog/blog-details">New Technologies<span className="icon-right-arrow"></span></Link> </li>
                                        <li><Link to="/blog/blog-details">Parallax Effects<span className="icon-right-arrow"></span></Link> </li>
                                        <li><Link to="/blog/blog-details">Web Development<span className="icon-right-arrow"></span></Link> </li>*/}
                                    </ul>
                                </div>
                                <div className="sidebar__single sidebar__tags">
                                    <h3 className="sidebar__title">Tags</h3>
                                    <div className="sidebar__tags-list"> 
                                        
                                    { tags.map(item => (
                                        <Link to={"/blog/tag/"+item.blog_tag_urltitle+"-"+item.blog_tag_id}>{item.blog_tag_name}</Link>
                                    ))}
                                        {/*
                                        <Link to="#">Consulting</Link> <Link to="#">Agency</Link> <Link to="#">Business</Link> <Link to="#">Digital</Link> <Link to="#">Experience</Link> <Link to="#">Technology</Link>*/} </div>
                                </div>
                                {/*
                                <div className="sidebar__single sidebar__comments">
                                    <h3 className="sidebar__title">Recent Comments</h3>
                                    <ul className="sidebar__comments-list list-unstyled">
                                        <li>
                                            <div className="sidebar__comments-icon"> <i className="fas fa-comments"></i> </div>
                                            <div className="sidebar__comments-text-box">
                                                <p>A wordpress commenter on <br/> launch new mobile app</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div className="sidebar__comments-icon"> <i className="fas fa-comments"></i> </div>
                                            <div className="sidebar__comments-text-box">
                                                <p> <span>John Doe</span> on template:</p>
                                                <h5>comments</h5>
                                            </div>
                                        </li>
                                        <li>
                                            <div className="sidebar__comments-icon"> <i className="fas fa-comments"></i> </div>
                                            <div className="sidebar__comments-text-box">
                                                <p>A wordpress commenter on <br/> launch new mobile app</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div className="sidebar__comments-icon"> <i className="fas fa-comments"></i> </div>
                                            <div className="sidebar__comments-text-box">
                                                <p> <span>John Doe</span> on template:</p>
                                                <h5>comments</h5>
                                            </div>
                                        </li>
                                    </ul>
                                </div>*/}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <Footer />
        </>
    );
}

export default NewsDetails;
