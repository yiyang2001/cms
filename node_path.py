import os
import sys
import argparse

def add_node_path():
    node_path = r'C:\node-v18.15.0-win-x64'
    path = os.getenv('PATH', '')
    if node_path not in path:
        os.environ['PATH'] = f'{path};{node_path}'
        print(f'Node path added to PATH environment variable: {node_path}')
    else:
        print(f'Node path is already in PATH environment variable: {node_path}')

def remove_node_path():
    node_path = r'C:\node-v18.15.0-win-x64'
    path = os.getenv('PATH', '')
    new_path = path.replace(f';{node_path}', '')
    if new_path != path:
        os.environ['PATH'] = new_path
        print(f'Node path removed from PATH environment variable: {node_path}')
    else:
        print(f'Node path is not in PATH environment variable: {node_path}')

def display_path():
    path = os.getenv('PATH', '')
    print(f'Current session environment path:\n{path}')

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Set or remove the PATH environment variable to include C:\\node-v18.15.0-win-x64')
    parser.add_argument('-s', action='store_true', help='Set the PATH environment variable')
    parser.add_argument('-r', action='store_true', help='Remove the PATH environment variable')
    parser.add_argument('-d', action='store_true', help='Display the current session environment path')
    args = parser.parse_args()

    if args.s:
        add_node_path()
    elif args.r:
        remove_node_path()
    elif args.d:
        display_path()
    else:
        parser.print_help()
        sys.exit(1)
