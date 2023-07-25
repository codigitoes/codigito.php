import React from "react";
import BlogpostRepository, { Blogpost } from "../../infraestructure/BlogpostRepository";

const endpoint:string = 'http://localhost:8001/api/client/web/list';

const useBlogpostRepository = (repository:BlogpostRepository) => {
    const [blogposts,setBlogposts] = React.useState<Blogpost[]>([]);

    React.useEffect(()=>{
        repository.all().then(data => {
            const collection:Blogpost[] = [];
            data.map((item) => {
                console.log(item);
            });
        });
    },[repository]);

    return blogposts;
}

export default useBlogpostRepository;