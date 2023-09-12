import { Link, useParams } from "react-router-dom";
import useFetch from "../../hooks/useFetch";
import "./blog.scss";
import { CircularProgress } from "@mui/material";

interface BlogPageProps {
}

interface Blogpost {
    id: string;
    name: string;
    image: string;
    tags: string[];
    created: string;
}

const endpoint: string = 'http://localhost:8001/api/client/web/blog';

const BlogPage: React.FC<BlogPageProps> = ({ }) => {
    const { pattern } = useParams();
    const endpointFiltered = pattern !== undefined ? `${endpoint}/${pattern}` : endpoint;

    const fetchState = useFetch<{
        blogposts: Blogpost[]
    }>(endpointFiltered);

    if (fetchState.state === 'loading' || fetchState.state === 'idle') {
        return (<div><CircularProgress /></div>);
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