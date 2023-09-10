import { Link } from "react-router-dom";
import useFetch from "../../hooks/useFetch";
import "./blog.scss";

interface BlogPageProps {
}

interface Blogpost {
    id: string;
    name: string;
    image: string;
    tags: string[];
    created: string;
}

const endpoint: string = 'http://localhost:8001/api/client/web/list';

const BlogPage: React.FC<BlogPageProps> = ({ }) => {

    const fetchState = useFetch<{
        blogposts: Blogpost[]
    }>(endpoint);
    if (fetchState.state === 'loading' || fetchState.state === 'idle') {
        return (<div>loading...</div>);
    }

    const blogposts: Blogpost[] = fetchState.data?.blogposts ? fetchState.data.blogposts : [];


    return (
        <>
            <div className='blog-page'>
                {blogposts.map((blogpost) => {
                    return (
                        <Link to={`/blogpost/${blogpost.id}`} key={blogpost.id}>
                            <div className="box blog-item">
                                <img src={blogpost.image} alt="" />
                                <span>{blogpost.name}</span>
                            </div>
                        </Link>
                    );
                })}
            </div>
        </>
    );

};

export default BlogPage;