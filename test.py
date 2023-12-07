
from bs4 import BeautifulSoup
from IPython.display import HTML

# read the HTML file
with open('./https-10.95.222.25-7002-oamconsole/Testing.html', 'r') as f:
    html_text = f.read()

# create a BeautifulSoup object
soup = BeautifulSoup(html_text, 'html.parser')

# find all span tags with class "BODH0"
bodh0_spans = soup.find_all('span', class_='BODH0')

# iterate through the spans and store the content until the next BODH0 span is encountered
content_lists = []
for i in range(len(bodh0_spans) - 1):
    content_list = []
    start_span = bodh0_spans[i]
    end_span = bodh0_spans[i+1]
    curr_tag = start_span
    
    # find all BODH1 tags between two BODH0 tags
    while curr_tag != end_span:
        if curr_tag.name == 'span' and curr_tag['class'][0] == 'BODH1':
            # extract the response and the id attribute value of the BODH1 span tag
            response_html = ''
            response_tag = curr_tag.find_next('h2', text=lambda t: t and t.startswith('Response'))
            if response_tag:
                response_div = response_tag.find_next('div', class_='rr_div')
                response_html += str(response_tag) + str(response_div)
            bodh1_id = curr_tag.get('id')
            content_lists.append((bodh1_id, response_html))
        content_list.append(str(curr_tag))
        curr_tag = curr_tag.next_sibling
    
    content_lists.append(content_list)

# store the content from the last BODH0 span until the end of the document
last_content_list = []
last_start_span = bodh0_spans[-1]
last_curr_tag = last_start_span
while last_curr_tag is not None:
    last_content_list.append(str(last_curr_tag))
    last_curr_tag = last_curr_tag.next_sibling
    if last_curr_tag is not None and last_curr_tag.name == 'span' and last_curr_tag['class'][0] == 'BODH0':
        break
content_lists.append(last_content_list)

# prompt the user to choose a content list
num_lists = len(content_lists)
while True:
    choice = input(f"Enter a number between 1 and {num_lists} to view a content list, or 'q' to quit: ")
    if choice == 'q':
        break
    try:
        index = int(choice) - 1
        if index >= 0 and index < num_lists:
            # extract the response and the id attribute value of the BODH1 span tag in the content list
            html = ''.join(content_lists[index])  # join the list of strings into a single string
            soup = BeautifulSoup(html, 'html.parser')
            bodh1_tags = soup.find_all('span', class_='BODH1')
            for bodh1_tag in bodh1_tags:
                bodh1_id = bodh1_tag.get('id') if bodh1_tag else None
                response_tag = bodh1_tag.find_next('h2', text=lambda t: t and t.startswith('Response'))
                response_div = response_tag.find_next('div', class_='rr_div')
                response_html = str(response_tag) + str(response_div)
                if bodh1_id:
                    response_html = f'<span class="BODH1" id="{bodh1_id}"></span>' + response_html
                print(f"Content List {index+1} Response {bodh1_id}:")
                display(HTML(response_html))