# iGaming API Task

The task was realised with Symfony 5.1 components and API is covered with functional test.

- required PHP version is at least 7.2.5


The API checks directly from the source, whether the given URL matches any of the patterns in General Block EasyList.


CURL Example:

<pre>
curl --location --request GET 'http://igamingapi2/api/is-url-blocked-by-adblockers?url=http://www.abv.bg/-ad-iframe.' \
--form 'url=http://www.abv.bg'
</pre>
